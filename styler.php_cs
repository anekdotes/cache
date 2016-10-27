<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude(array(
      'vendor',
    ))
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    ->fixers(array(
      'align_double_arrow',
      'operators_spaces',
      'line_after_namespace',
      'blankline_after_open_tag',
      'return',
      'braces',
      'spaces_cast',
      //'class_definition???????',
      'concat_without_spaces',
      //'declare_equal_normalize??????',
      'elseif',
      'encoding',
      'short_tag',
      'function_declaration',
      'function_typehint_space',
      //'hash_to_slash_comment????',
      'include',
      //'lowercase_cast?????',
      'lowercase_constants',
      'lowercase_keywords',
      'method_argument_space',
      //'method_separation?????',
      //'native_function_casing???',
      'new_with_braces',
      'join_function', //instead of no_alias_functions
      'no_blank_lines_after_class_opening',
      'no_empty_lines_after_phpdocs',
      'php_closing_tag',
      //'no_empty_phpdoc???',
      'duplicate_semicolon', //instead of no_empty_statement
      'extra_empty_lines', //instead of no_extra_consecutive_blank_lines
      'remove_leading_slash_use', //instead of no_leading_import_slash
      'namespace_no_leading_whitespace', //instead of no_leading_namespace_whitespace
      'double_arrow_multiline_whitespaces', //instead of no_multiline_whitespace_around_double_arrow
      'short_bool_cast', //instead of no_short_bool_cast
      'spaces_before_semicolon', //no_singleline_whitespace_before_semicolons
      'function_call_space', //no_spaces_after_function_name
      //'no_spaces_inside_offset?????',
      'parenthesis', //no_spaces_inside_parenthesis
      'indentation', //no_tab_indentation
      'list_commas', //no_trailing_comma_in_list_call
      'single_array_no_trailing_comma', //no_trailing_comma_in_singleline_array
      'trailing_spaces', //no_trailing_whitespace
      //'no_trailing_whitespace_in_comment???',
      'unneeded_control_parentheses', //no_unneeded_control_parentheses
      //'no_unreachable_default_argument_value??????',
      'unused_use', //no_unused_imports
      //'no_useless_return????',
      'array_element_no_space_before_comma', //no_whitespace_before_comma_in_array
      'whitespacy_lines', //no_whitespace_in_blank_line
      //'normalize_index_brace?????',
      'object_operator', //object_operator_without_whitespace
      'ordered_use', //ordered_imports
      'phpdoc_params', //phpdoc_align
      'phpdoc_indent',
      'phpdoc_inline_tag',
      'phpdoc_no_access',
      'phpdoc_no_package',
      'phpdoc_order',
      'phpdoc_scalar',
      'phpdoc_separation',
      //'phpdoc_single_line_var_spacing?????',
      'phpdoc_short_description', //phpdoc_summary
      'phpdoc_to_comment',
      'phpdoc_trim',
      'phpdoc_type_to_var',
      'phpdoc_types',
      'phpdoc_var_without_name',
      'print_to_echo',
      //'psr4?????',
      'self_accessor',
      'short_array_syntax',
      //'short_scalar_cast?????',
      'empty_return', //simplified_null_return
      'eof_ending', //single_blank_line_at_eof
      'single_blank_line_before_namespace',
      //'single_class_element_per_statement?????',
      'multiple_use', //single_import_per_statement
      'single_line_after_imports',
      'single_quote',
      //'space_after_semicolon????',
      'standardize_not_equal', //standardize_not_equals
      //'switch_case_semicolon_to_colon????',
      'switch_case_space',
      'ternary_spaces', //ternary_operator_spaces
      'multiline_array_trailing_comma', //trailing_comma_in_multiline_array
      'trim_array_spaces',
      'unalign_equals',
      'unary_operators_spaces', //unary_operator_spaces
      'linefeed', //unix_line_endings
      'visibility', //visibility_required
      'array_element_white_space_after_comma', //whitespace_after_comma_in_array
    ))
    ->finder($finder)
;
