From: "Cal Henderson" <cal@iamcal.com>
To: <smarty-general@lists.php.net>
Date: Mon, 6 Jun 2005 00:05:20 -0700
Content-Type: text/plain; charset="Windows-1252"
Content-Transfer-Encoding:1 7bit
Subject: Re: [SMARTY] Getting information about the template name

Erik Schmitt wrote:
: I would like to access the name of current template
: directly from the Smarty-object (inside my own BLOCK-function).
: Is this possible? I searched the documentation but
: found only {$smarty.template}, which does not help me.

a quick print_r reveals it's stashed in the smarty
object. try a function like this:

 function myfunc($args, $smarty){
  $tmpl = $smarty->_plugins['function']['myfunc'][1];
  ...
 }
 $smarty->register_function('myfunc', 'myfunc');

but that doesn't work for included templates. to get
the template name inside includes you'll need to patch
your Smarty.class.php file with the patch here:

http://code.iamcal.com/php/smarty/current_template/diff.txt

then you can access it like this:

 function myfunc($args, $smarty){
  $tmpl = $smarty->current_template();
  ...
 }


--cal 

-- 
Smarty General Mailing List (http://smarty.php.net/)
To unsubscribe, visit: http://www.php.net/unsub.php
