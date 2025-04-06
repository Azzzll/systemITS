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

/* view_create.twig */
class __TwigTemplate_d5723fe21f825b97b8e5e7b363c049822237e6782b55489c4d14f28d65faca02 extends Template
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
        yield "<!-- CREATE VIEW options -->
<div id=\"div_view_options\">
    <form method=\"post\" action=\"";
        // line 3
        yield PhpMyAdmin\Url::getFromRoute("/view/create");
        yield "\">
    ";
        // line 4
        yield PhpMyAdmin\Url::getHiddenInputs(($context["url_params"] ?? null));
        yield "
    <fieldset class=\"pma-fieldset\">
        <legend>
            ";
        // line 7
        if (($context["ajax_dialog"] ?? null)) {
            // line 8
            yield "                ";
yield _gettext("Details");
            // line 9
            yield "            ";
        } else {
            // line 10
            yield "                ";
            if (((($__internal_compile_0 = ($context["view"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["operation"] ?? null) : null) == "create")) {
                // line 11
                yield "                    ";
yield _gettext("Create view");
                // line 12
                yield "                ";
            } else {
                // line 13
                yield "                    ";
yield _gettext("Edit view");
                // line 14
                yield "                ";
            }
            // line 15
            yield "            ";
        }
        // line 16
        yield "        </legend>
        <table class=\"table align-middle rte_table\">
            ";
        // line 18
        if (((($__internal_compile_1 = ($context["view"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1["operation"] ?? null) : null) == "create")) {
            // line 19
            yield "                <tr>
                    <td class=\"text-nowrap\"><label for=\"or_replace\">OR REPLACE</label></td>
                    <td>
                        <input type=\"checkbox\" name=\"view[or_replace]\" id=\"or_replace\"
                            ";
            // line 23
            if ((($__internal_compile_2 = ($context["view"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2["or_replace"] ?? null) : null)) {
                yield " checked=\"checked\" ";
            }
            // line 24
            yield "                            value=\"1\">
                    </td>
                </tr>
            ";
        }
        // line 28
        yield "
            <tr>
                <td class=\"text-nowrap\"><label for=\"algorithm\">ALGORITHM</label></td>
                <td>
                    <select name=\"view[algorithm]\" id=\"algorithm\">
                        ";
        // line 33
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["view_algorithm_options"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 34
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\"
                                ";
            // line 35
            if (((($__internal_compile_3 = ($context["view"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3["algorithm"] ?? null) : null) == $context["option"])) {
                // line 36
                yield "                                    selected=\"selected\"
                                ";
            }
            // line 38
            yield "                            >";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        yield "                    </select>
                </td>
            </tr>

            <tr>
                <td class=\"text-nowrap\">";
yield _gettext("Definer");
        // line 45
        yield "</td>
                <td><input type=\"text\" maxlength=\"100\" size=\"50\" name=\"view[definer]\" value=\"";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_4 = ($context["view"] ?? null)) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4["definer"] ?? null) : null), "html", null, true);
        yield "\"></td>
            </tr>

            <tr>
                <td class=\"text-nowrap\">SQL SECURITY</td>
                <td>
                    <select name=\"view[sql_security]\">
                        <option value=\"\"></option>
                        ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["view_security_options"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 55
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\"
                                ";
            // line 56
            if (($context["option"] == (($__internal_compile_5 = ($context["view"] ?? null)) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5["sql_security"] ?? null) : null))) {
                yield " selected=\"selected\" ";
            }
            // line 57
            yield "                            >";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        yield "                    </select>
                </td>
            </tr>

            ";
        // line 63
        if (((($__internal_compile_6 = ($context["view"] ?? null)) && is_array($__internal_compile_6) || $__internal_compile_6 instanceof ArrayAccess ? ($__internal_compile_6["operation"] ?? null) : null) == "create")) {
            // line 64
            yield "                <tr>
                    <td class=\"text-nowrap\">";
yield _gettext("VIEW name");
            // line 65
            yield "</td>
                    <td>
                        <input type=\"text\" size=\"20\" name=\"view[name]\" onfocus=\"this.select()\" maxlength=\"64\" value=\"";
            // line 67
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_7 = ($context["view"] ?? null)) && is_array($__internal_compile_7) || $__internal_compile_7 instanceof ArrayAccess ? ($__internal_compile_7["name"] ?? null) : null), "html", null, true);
            yield "\">
                    </td>
                </tr>
            ";
        } else {
            // line 71
            yield "                <tr>
                    <td>
                        <input type=\"hidden\" name=\"view[name]\" value=\"";
            // line 73
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_8 = ($context["view"] ?? null)) && is_array($__internal_compile_8) || $__internal_compile_8 instanceof ArrayAccess ? ($__internal_compile_8["name"] ?? null) : null), "html", null, true);
            yield "\">
                    </td>
                </tr>
            ";
        }
        // line 77
        yield "
            <tr>
                <td class=\"text-nowrap\">";
yield _gettext("Column names");
        // line 79
        yield "</td>
                <td>
                    <input type=\"text\" maxlength=\"100\" size=\"50\" name=\"view[column_names]\" onfocus=\"this.select()\"  value=\"";
        // line 81
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_9 = ($context["view"] ?? null)) && is_array($__internal_compile_9) || $__internal_compile_9 instanceof ArrayAccess ? ($__internal_compile_9["column_names"] ?? null) : null), "html", null, true);
        yield "\">
                </td>
            </tr>

            <tr>
                <td class=\"text-nowrap\">AS</td>
                <td>
                    <textarea name=\"view[as]\" id=\"view_as\" rows=\"15\" cols=\"40\" dir=\"";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_dir"] ?? null), "html", null, true);
        yield "\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($__internal_compile_10 = ($context["view"] ?? null)) && is_array($__internal_compile_10) || $__internal_compile_10 instanceof ArrayAccess ? ($__internal_compile_10["as"] ?? null) : null), "html", null, true);
        yield "</textarea><br>
                    <input type=\"button\" value=\"Format\" id=\"format\" class=\"btn btn-secondary button sqlbutton\">
                    <span id=\"querymessage\"></span>
                </td>
            </tr>

            <tr>
                <td class=\"text-nowrap\">WITH CHECK OPTION</td>
                <td>
                    <select name=\"view[with]\">
                        <option value=\"\"></option>
                        ";
        // line 99
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["view_with_options"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 100
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\"
                                ";
            // line 101
            if (($context["option"] == (($__internal_compile_11 = ($context["view"] ?? null)) && is_array($__internal_compile_11) || $__internal_compile_11 instanceof ArrayAccess ? ($__internal_compile_11["with"] ?? null) : null))) {
                yield " selected=\"selected\" ";
            }
            // line 102
            yield "                            >";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 104
        yield "                    </select>
                </td>
            </tr>

        </table>
    </fieldset>

    <input type=\"hidden\" name=\"ajax_request\" value=\"1\" />
    <input type=\"hidden\" name=\"";
        // line 112
        yield ((((($__internal_compile_12 = ($context["view"] ?? null)) && is_array($__internal_compile_12) || $__internal_compile_12 instanceof ArrayAccess ? ($__internal_compile_12["operation"] ?? null) : null) == "create")) ? ("createview") : ("alterview"));
        yield "\" value=\"1\" />

    ";
        // line 114
        if ((($context["ajax_dialog"] ?? null) == false)) {
            // line 115
            yield "        <input type=\"hidden\" name=\"ajax_dialog\" value=\"1\" />
        <input type=\"submit\" class=\"btn btn-primary\" name=\"\" value=\"";
yield _gettext("Go");
            // line 116
            yield "\" />
    ";
        }
        // line 118
        yield "
    </form>
</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "view_create.twig";
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
        return array (  291 => 118,  287 => 116,  283 => 115,  281 => 114,  276 => 112,  266 => 104,  257 => 102,  253 => 101,  248 => 100,  244 => 99,  228 => 88,  218 => 81,  214 => 79,  209 => 77,  202 => 73,  198 => 71,  191 => 67,  187 => 65,  183 => 64,  181 => 63,  175 => 59,  166 => 57,  162 => 56,  157 => 55,  153 => 54,  142 => 46,  139 => 45,  131 => 40,  122 => 38,  118 => 36,  116 => 35,  111 => 34,  107 => 33,  100 => 28,  94 => 24,  90 => 23,  84 => 19,  82 => 18,  78 => 16,  75 => 15,  72 => 14,  69 => 13,  66 => 12,  63 => 11,  60 => 10,  57 => 9,  54 => 8,  52 => 7,  46 => 4,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "view_create.twig", "C:\\OSPanel\\home\\projects\\systemITS\\phpmyadmin\\templates\\view_create.twig");
    }
}
