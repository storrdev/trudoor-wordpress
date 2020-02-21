<?php
/**
 * @author: Andrew Kozell <andrew@goivio.com>
 * @since: 8/10/16
 * @package: wigum
 */

require($_SERVER['DOCUMENT_ROOT'] . '/library/core.php');

try {

    $db = \Wigum\Core\Mysql::db();

    $result = $db->query("SHOW TABLES LIKE 'version'");

    if ($result->num_rows) {
        throw new Exception('Database already installed');
    }

    $controller = Wigum\Core\Load::controller('update.admin.database')->Run();

    header('Location: /');

} catch (Exception $e) {
    header('Location: /');
    exit();

}