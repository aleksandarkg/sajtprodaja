<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/sajtprodaja/');
define ('CART_COOKIE', 'SBwi72UCklwiqzz2');
define ('CART_COOKIE_EXPIRE', time() + (86400 * 30));
define ('TAXRATE', 0.087);//Sales tax rate. Set to 0 if you are not charging tax

define('CURRENCY', 'usd');
define('CHECKOUTMODE', 'TEST'); //Change TEST to LIVE when you ready to go LIVE

if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE', 'sk_test_EQYFuWRhrW3KkLYUZmcp5pMi');
	define('STRIPE_PUBLIC', 'pk_test_3fLibDxbeFkI6oNGjsz060Ik');
}

if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE', 'sk_live_VbpviVGuL5khwP9V69qr9udU');
	define('STRIPE_PUBLIC', 'pk_live_9tPeLlqAZVWoXzqLPniKWxls');
}