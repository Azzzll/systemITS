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

/* server/select/server_options.twig */
class __TwigTemplate_aee868c610d17f52d9ca870155883fa4598d76c1402847b08a6064ad66181dee extends Template
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
        $context['_seq'] = CoreExtension::ensureTraversable(($context["select"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["server"]) {
            // line 2
            yield "    <option
        value=\"";
            // line 3
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["server"], "value", [], "any", false, false, false, 3), "html", null, true);
            yield "\"
        ";
            // line 4
            if (CoreExtension::getAttribute($this->env, $this->source, $context["server"], "selected", [], "any", false, false, false, 4)) {
                yield "selected=\"selected\"";
            }
            // line 5
            yield "    >";
            // line 6
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["server"], "label", [], "any", false, false, false, 6), "html", null, true);
            // line 7
            yield "</option>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['server'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "server/select/server_options.twig";
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
        return array (  57 => 7,  55 => 6,  53 => 5,  49 => 4,  45 => 3,  42 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "server/select/server_options.twig", "C:\\OSPanel\\home\\projects\\systemITS\\phpmyadmin\\templates\\server\\select\\server_options.twig");
    }
}
