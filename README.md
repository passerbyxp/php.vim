php.vim
=======

This project is a fork of [php.vim][kristijanhusak] which is a fork of [php.vim][StanAngeloff] which is an improved version
of [php.vim--Garvin][garvin] which in turn is an update of the [php.vim][php-vim] script which in turn is an updated version of the php.vim syntax file distributed with Vim.

  [kristijanhusak]: https://github.com/kristijanhusak/php.vim
  [StanAngeloff]: https://github.com/StanAngeloff/php.vim
  [garvin]:  https://github.com/vim-scripts/php.vim--Garvin
  [php-vim]: http://www.vim.org/scripts/script.php?script_id=2874

Improvements
------------

- Modified the `update_syntax.php` so that it always reflect your current extensions, instead of having to check and hand-writing extensions on and off.

Customising
-----------

A script `update_syntax.php` is provided to re-generate the syntax file.
~A single variable `$allowed_extensions` can be customised to~
~[turn on/off][defaults] certain extensions.~

~When re-generating the syntax file, you must have allowed extensions installed.~

  [defaults]: https://github.com/StanAngeloff/php.vim/blob/master/update_syntax.php#L29-L101

### Original README

> This is an updated version of the php.vim syntax file distributed with VIM.
> The list of PHP constants, functions, and classes was updated to be current
> with PHP 5.3. Many new classes were added in the 5.2 branch and the
> distributed version only covers up to 5.1.4. In addition I simplified the
> file, removing several sections that are not often used (at least by me) such
> as automatic folding of all control structures and ASP tags support. I also
> removed several switches designed for b/c with VIM 5.X and 6.X. As an
> addition I have included the PHP file I used to generate the constant,
> function, class list. It uses reflection to mine out these items from your
> PHP installation and generate part of the php.vim script. Before running open
> up the file and adjust the output file location and the list of extensions to
> generate syntax for. Then run "php php_vimgen.php" from your shell.
