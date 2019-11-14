<?php 
public function setArgument($arg) {
  // If we are not dealing with the exception argument, example "all".
  if ($this->isException($arg)) {
    return parent::setArgument($arg);
  }
  // Convert slug to taxonomy term ID.
  $tid = is_numeric($arg)
    ? $arg : $this->convertSlugToTid($arg);
  $this->argument = (int) $tid;
  return $this->validateArgument($tid);
}