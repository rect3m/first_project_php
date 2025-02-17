<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setRules([
        '@PSR2' => true,
        'blank_line_after_namespace' => true,
        'class_definition' => true,
        'elseif' => true,
        'encoding' => true,
        'full_opening_tag' => true,
        'function_declaration' => true,
        'indentation_type' => true,
        'constant_case' => ['case' => 'lower'],
        'method_argument_space' => true,
        'no_break_comment' => true,
        'no_closing_tag' => true,
        'no_spaces_after_function_name' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_extra_blank_lines' => true,
        'align_multiline_comment' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'blank_line_after_opening_tag' => true,
        'cast_spaces' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => ['spacing' => 'one'],
        'explicit_indirect_variable' => true,
        'fully_qualified_strict_types' => true,
        'function_typehint_space' => true,
        'linebreak_after_opening_tag' => true,
        'lowercase_static_reference' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_null_property_initialization' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_useless_return' => true,
        'no_useless_else' => true,
        'ordered_imports' => true,
        'ordered_class_elements' => true,
        'single_quote' => true,
        'whitespace_after_comma_in_array' => true,
        'backtick_to_shell_exec' => true,
        'class_attributes_separation' => true,
        'no_superfluous_elseif' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'trim_array_spaces' => true,
        'space_after_semicolon' => true,
    ])
    ->setFinder(
        Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    );
