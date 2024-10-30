<?php
/**
\mainpage Vigorous Hive Loosely-Coupled Components 

The point is to create components for php which could be used in almost ANY application architecture. You can use whem alone (this is the best), or you can embed them into existing site, cms or framework \n \n

 Some useful features:
\li Each component can be used as standalone web-application
\li Event-based logic, with Event Handlers, which can be defined anywhere and than passed to the control
\li Model/View/Control levels are totally independant. You can use same cotrols with different views and(or) models without changing control code
\li Flexible access control on every control and event. You can implement your own ACL class and get total control over user access, or you can use standart libraries like Zend_Acl or VihvXmlAcl
\li XSLT based templetes for HTML output, however you can use any other templates if you want
\n \n
 * 
 * @version 3.0.2-alpha
*/

require_once 'autoload.php';
