<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/custom/demo_view/templates/views-view-fields--demo-view--show-view.html.twig */
class __TwigTemplate_f719a2c326da7d06e11d4779089e51a77fdc2aa0a7a3185b8ef9e7886912b2e3 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = ["escape" => 2];
        $functions = ["dump" => 3];

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
                ['dump']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<h1>bfdhfhj</h1>
Name:<p>";
        // line 2
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["iname"] ?? null)), "html", null, true);
        echo "</p>
Age:<p>";
        // line 3
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_var_dump($this->env, $context, [0 => $this->sandbox->ensureToStringAllowed(($context["age"] ?? null))]), "html", null, true);
        echo "</p>
IsActive: <p>";
        // line 4
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["fields"] ?? null), "is_active", [])), "html", null, true);
        echo "</p>
Project Code: <p>";
        // line 5
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "project_code", [])), "html", null, true);
        echo "</p>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/demo_view/templates/views-view-fields--demo-view--show-view.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 5,  66 => 4,  62 => 3,  58 => 2,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<h1>bfdhfhj</h1>
Name:<p>{{ iname }}</p>
Age:<p>{{dump(age)}}</p>
IsActive: <p>{{ fields.is_active }}</p>
Project Code: <p>{{ content.project_code }}</p>
", "modules/custom/demo_view/templates/views-view-fields--demo-view--show-view.html.twig", "/var/www/html/yahoo/modules/custom/demo_view/templates/views-view-fields--demo-view--show-view.html.twig");
    }
}
