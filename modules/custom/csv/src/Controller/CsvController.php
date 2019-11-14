<?php
/**
 * @file
 * Contains \Drupal\csv\Controller\CsvController.
 */
namespace Drupal\csv\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StreamWrapper\PrivateStream;
use Drupal\Core\StreamWrapper\PublicStream;
use Drupal\Core\Link;
use Drupal\Core\Url;
/**
 * Class Csvexport.
 *
 * @package Drupal\csv\Controller
 */
class CsvController extends ControllerBase{
    public function csv_pgdcbm_form_submission(){
        $nodes = db_select('admission_pgdcbm_personal_details', 'p');
        $nodes->innerjoin('admission_pgdcbm_qualification_details', 'q', 'q.application_id = p.application_id');
        $nodes->innerjoin('admission_pgdcbm_job_details', 'j', 'j.application_id = p.application_id');
        $nodes->fields('p', array('name', 'designation', 'official_address', 'phone', 'fax', 'residential_address', 'mobile', 'landline', 'date_of_birth', 'age'));
        $nodes->fields('q', array('university', 'year_of_passing', 'grade', 'university_pg', 'year_of_passing_pg', 'grade_pg',
        'university_ao', 'year_of_passing_ao', 'grade_ao'));
        $nodes->fields('j', array('organization', 'post_held', 'nature_of_work', 'from_date', 'to_date'));
        $applications = $nodes->execute();
        $private_path = PrivateStream::basepath();
        $public_path = PublicStream::basepath();
        $file_base = ($private_path) ? $private_path : $public_path;
        $filename = 'pgdcbm_'. time(). '.csv';
        $filepath = $file_base . '/' . $filename;     
        $csvFile = fopen($filepath, "w");
        fputcsv($csvFile, array( 'Application no.', 'Name' , 'Designation',
                                 'Official Address', 'Phone' , 'Fax',
                                 'Degree University', 'Degree Grade' , 'Degree YOP',
                                 'PG University ', 'PG Grade' , 'PG YOP',
                                 'Other University ', 'Other Grade' , 'Other YOP',
                                 'Organization', 'Post',  'Nature of Work',
                                 'From','To'
                                )
                );
        foreach($applications as $row => $application){
            fputcsv($csvFile,array( 
                      $application->application_id, $application->name, $application->designation,
                      $application->official_address,$application->phone,$application->fax, 
                      $application->university, $application->grade ,$application->year_of_passing,
                      $application->university_pg, $application->grade_pg,$application->year_of_passing_pg,
                      $application->university_ao,$application->grade_ao,$application->year_of_passing_ao,
                      $application->organization,$application->post_held,$application->nature_of_work,
                      $application->from_date,$application->to_date
                  )
                );
        }
        fclose($csvFile);   
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'. basename($filepath) . '";');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        unlink($filepath);
        exit();
    }
    public function csv_dmco_form_submission(){
        $nodes = db_select('admission_dmco_personal_details', 'p');
        $nodes->innerjoin('admission_dmco_sponsor_details', 's', 's.application_id = p.application_id');
        $nodes->innerjoin('admission_dmco_payment_details', 'j', 'j.application_id = p.application_id');
        $nodes->fields('p', array('name', 'designation', 'residential_address_with_pin', 'phone', 'date_of_birth', 'academic_qualification', 'computer_qualification', 'residential'));
        $nodes->fields('s', array('sponsor_name', 'address', 'pin_code', 'fax', 'email'));
        $nodes->fields('j',  array('cheque_dd_no', 'cheque_dd_date', 'bank_name', 'amount'));
        $applications = $nodes->execute();
        $private_path = PrivateStream::basepath();
        $public_path = PublicStream::basepath();
        $file_base = ($private_path) ? $private_path : $public_path;
        $filename = 'dmco_'. time(). '.csv';
        $filepath = $file_base . '/' . $filename;     
        $csvFile = fopen($filepath, "w");
        fputcsv($csvFile, array
                        ( 'Name' , 'Designation',
                         'Residential Address', 'Phone' , 'Date of Birth',
                         'Academic Qualification', 'Computer Qualification' , 'Residential',
                         'Sponsor Name ', 'Address' , 'Pincode',
                         'Fax ', 'Email' , 'Cheque / DD No','Cheque Date',
                         'Bank Name', 'Amount'
                        )
        );
        foreach($applications as $row => $application){
          fputcsv($csvFile, array
                ( 
                  $application->name, $application->designation, $application->residential_address_with_pin, $application->phone,
                  $application->date_of_birth, $application->academic_qualification, $application->computer_qualification,
                  $application->residential, $application->sponsor_name, $application->address, $application->pin_code, $application->fax,
                  $application->email, $application->cheque_dd_no, $application->cheque_dd_date, $application->bank_name, $application->amount
                )
          );
        }
        fclose($csvFile);   
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'. basename($filepath) . '";');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        unlink($filepath);
        exit();
    }
    public function csv_pgdm_form_submission() {
        $nodes = db_select('admission_pgdm_personal_details', 'p');
        $nodes->innerjoin('admission_pgdm_nlcet_details', 'c', 'c.application_id = p.application_id');
        $nodes->innerjoin('admission_pgdm_work_exp', 'w', 'w.application_id = p.application_id' );
        $nodes->innerjoin('admission_pgdm_edu_details', 'e', 'e.application_id = p.application_id');
        $nodes->fields('p', array('name', 'parent_name', 'parent_occupation', 'mailing_address', 'pin_code',
        'mobile', 'email', 'permanent_address', 'pin_code1', 'email1', 'phone', 'fax', 'mobile1',
        'date_of_birth', 'gender', 'category'));
        $nodes->fields('c', array('exam_name', 'month_year_of_exam', 'exam_validity', 'exam_score', 'selected_centres'));
        $nodes->fields('w', array('organization_name', 'designation', 'salary_drawn', 'working_from', 'working_till'));
        $nodes->fields('e', array('course_completion', 'board_university', 'year', 'max_marks', 'marks_obtained', 'percentage_marks', 'class_grade'));
        $applications = $nodes->execute();
        $private_path = PrivateStream::basepath();
        $public_path = PublicStream::basepath();
        $file_base = ($private_path) ? $private_path : $public_path;
        $filename = 'pgdm_'. time(). '.csv';
        $filepath = $file_base . '/' . $filename;     
        $csvFile = fopen($filepath, "w");
        fputcsv($csvFile, array('Name','Parent Name', 'Parent Occupation', 'Mailing Address', 'Pin Code', 'Mobile', 'Email', 'Parmenanent Address', 'Pin Code', 'Email', 'Phone', 'Fax', 'Mobile','Date of Birth','gender', 'Category', 'Exam Name', 'Exam Year', 'Exam Validity', 'Exam Score', 'Selected Centres', 'Organization Name', 'Designation', 'Salary Drawn','Working From', 'Working Till','Course Completion', 'Board / University', 'year', 'Max Marks', 'Marks Obtain', 'Percentage Marks','Class Grade')
      );
      foreach($applications as $row => $application){
          fputcsv($csvFile, array
                ( 
                  $application->name, $application->parent_name, $application->parent_occupation, 
                  $application->mailing_address,$application->pin_code, $application->mobile, 
                  $application->email, $application->permanent_address, $application->pin_code1,
                  $application->email1, $application->phone, $application->fax, $application->mobile1, 
                  $application->date_of_birth, $application->gender,$application->category, 
                  $application->exam_name, $application->month_year_of_exam, $application->exam_validity, 
                  $application->exam_score, $application->selected_centres,
                  $application->organization_name, 
                  $application->designation, $application->salary_drawn, $application->working_from,
                  $application->working_till, $application->course_completion, 
                  $application->board_university, $application->year, 
                  $application->max_marks, $application->marks_obtained, 
                  $application->percentage_marks, $application->class_grade
                )
          );
      }
      fclose($csvFile);   
      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="'. basename($filepath) . '";');
      header('Content-Length: ' . filesize($filepath));
      readfile($filepath);
      unlink($filepath);
      exit();
    }
}
