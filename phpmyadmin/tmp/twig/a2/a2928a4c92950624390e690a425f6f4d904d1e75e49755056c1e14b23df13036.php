<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* file_select_options.twig */
class __TwigTemplate_6d1cecc39ea80f28ba8ab836ab26ccda5c4d5bdc9a4da621350a3150bf2992b2 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["filesList"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["file"]) {
            // line 2
            yield "  <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["file"], "html", null, true);
            yield "\"";
            if (($context["file"] == ($context["active"] ?? null))) {
                yield " selected=\"selected\"";
            }
            yield ">
    ";
            // line 3
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["file"], "html", null, true);
            yield "
  </option>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['file'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "file_select_options.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  51 => 3,  42 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "file_select_options.twig", "C:\\OSPanel\\home\\projects\\systemITS\\phpmyadmin\\templates\\file_select_options.twig");
    }
}
