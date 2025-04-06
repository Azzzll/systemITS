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

/* server/select/index.twig */
class __TwigTemplate_80d861bf3ec473887521f6dc2dc1fe706e996a8434dbbca359898e3aa7c33914 extends Template
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
        if (($context["not_only_options"] ?? null)) {
            // line 2
            yield "    <form class=\"disableAjax\" method=\"post\" action=\"";
            yield ($context["form_action"] ?? null);
            yield "\">
        ";
            // line 3
            if ((($context["omit_fieldset"] ?? null) == false)) {
                // line 4
                yield "            <fieldset class=\"pma-fieldset\">
        ";
            }
            // line 6
            yield "        ";
            yield PhpMyAdmin\Url::getHiddenFields([]);
            yield "
        <label for=\"select_server\">";
yield _gettext("Current server:");
            // line 7
            yield "</label>
        <select id=\"select_server\" class=\"autosubmit\" name=\"server\">
            <option value=\"\">(";
yield _gettext("Servers");
            // line 9
            yield ") ...</option>
            ";
            // line 10
            yield from             $this->loadTemplate("server/select/server_options.twig", "server/select/index.twig", 10)->unwrap()->yield(CoreExtension::toArray(["select" => CoreExtension::getAttribute($this->env, $this->source,             // line 11
($context["servers"] ?? null), "select", [], "any", false, false, false, 11)]));
            // line 13
            yield "        </select>
        ";
            // line 14
            if ((($context["omit_fieldset"] ?? null) == false)) {
                // line 15
                yield "            </fieldset>
        ";
            }
            // line 17
            yield "    </form>
";
        } elseif (CoreExtension::getAttribute($this->env, $this->source,         // line 18
($context["servers"] ?? null), "list", [], "any", false, false, false, 18)) {
            // line 19
            yield "    ";
yield _gettext("Current server:");
            yield "<br>
    <ul id=\"list_server\">
        <li>
            ";
            // line 22
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["servers"] ?? null), "list", [], "any", false, false, false, 22));
            foreach ($context['_seq'] as $context["_key"] => $context["server"]) {
                // line 23
                yield "                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["server"], "selected", [], "any", false, false, false, 23)) {
                    // line 24
                    yield "                    <strong>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["server"], "label", [], "any", false, false, false, 24), "html", null, true);
                    yield "</strong>
                ";
                } else {
                    // line 26
                    yield "                    <a class=\"disableAjax item\" href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["server"], "href", [], "any", false, false, false, 26), "html", null, true);
                    yield "\">";
                    // line 27
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["server"], "label", [], "any", false, false, false, 27), "html", null, true);
                    // line 28
                    yield "</a>
                ";
                }
                // line 30
                yield "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['server'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            yield "        </li>
    </ul>
";
        } else {
            // line 34
            yield "    ";
            yield from             $this->loadTemplate("server/select/server_options.twig", "server/select/index.twig", 34)->unwrap()->yield(CoreExtension::toArray(["select" => CoreExtension::getAttribute($this->env, $this->source,             // line 35
($context["servers"] ?? null), "select", [], "any", false, false, false, 35)]));
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "server/select/index.twig";
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
        return array (  125 => 35,  123 => 34,  118 => 31,  112 => 30,  108 => 28,  106 => 27,  102 => 26,  96 => 24,  93 => 23,  89 => 22,  82 => 19,  80 => 18,  77 => 17,  73 => 15,  71 => 14,  68 => 13,  66 => 11,  65 => 10,  62 => 9,  57 => 7,  51 => 6,  47 => 4,  45 => 3,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "server/select/index.twig", "C:\\OSPanel\\home\\projects\\systemITS\\phpmyadmin\\templates\\server\\select\\index.twig");
    }
}
