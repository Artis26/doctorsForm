<?php
namespace App\Controllers;

use App\Database;
use PDO;
use Slim\Views\PhpRenderer;

class HomeController {

    public function __construct() {
        $this->view = new PhpRenderer(__DIR__.'/../../resources/view');
    }

    public function getFormByPersonsId($request, $response, $args) {
        $val = $_POST['id'];

        $rows = Database::connection()->prepare('SELECT id, `4`, created_at FROM doctors_form WHERE `4` = ? and status != ? ORDER BY created_at DESC');
        $rows->execute([$val, 'deleted']);

        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }
        return $response->withJson($users);
    }

    public function searchPerson($request, $response, $args) {
        $val = $_POST['id'];

        $rows = Database::connection()->prepare('SELECT id, `4` FROM doctors_form WHERE `4` LIKE ? and status != ?');
        $rows->execute([$val.'%', 'deleted']);

        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }

        return $response->withJson($users);
    }

    public function displayPerson($request, $response, $args) {
        $val = $args['id'];

        $rows = Database::connection()->prepare('SELECT * FROM doctors_form WHERE `id` = ?');
        $rows->execute([$val]);

        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $user = $row;
        }

        return $this->view->render($response, "display.html", ['user' => $user]);
    }

    public function getPersonsData($request, $response, $args) {
        $val = $_POST['id'];
        $rows = Database::connection()->prepare('SELECT * FROM doctors_form WHERE `id` = ?');
        $rows->execute([$val]);

        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $user = $row;
        }
        return $response->withJson($user);
    }
    
    public function saveFirstPart($request, $response, $args): void {

        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"));

        $query = Database::connection()->prepare('INSERT INTO doctors_form (`1`, `2`, 
                               `3`, `4`, `5`, `6` , `7`, `8`) VALUES (?, ? ,?, ?, ?, ?, ?, ?)');
        $query->execute([$data->{'1'}, $data->{'2'}, $data->{'3'}, $data->{'4'},
            $data->{'5'}, $data->{'6'}, $data->{'7'}, $data->{'8'}]);


    }

    public function saveSecondPart($request, $response, $args) {
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"));

        $id = Database::connection()->prepare('SELECT MAX( id ) FROM doctors_form');
        $id->execute();
        while ($row = $id->fetch(PDO::FETCH_ASSOC)) {
            $user = $row;
        }

        $id = $user['MAX( id )'];

        $query = Database::connection()->prepare('UPDATE doctors_form SET `9` = ?, `10` = ?, 
                               `11` = ?, `12` = ?, `13` = ?, `14` = ? , `15` = ? WHERE id = ?');
        $query->execute([$data->{'9'}, $data->{'10'}, $data->{'11'}, $data->{'12'},
            $data->{'13'}, $data->{'14'}, $data->{'15'}, $id]);

        return $response->withRedirect('/');
    }

    public function deleteCurrentForm($request, $response, $args): void {

        $id = Database::connection()->prepare('SELECT MAX( id ) FROM doctors_form');
        $id->execute();
        while ($row = $id->fetch(PDO::FETCH_ASSOC)) {
            $user = $row;
        }

        $id = $user['MAX( id )'];
        $query = Database::connection()->prepare('DELETE FROM doctors_form WHERE id = ?');
        $query->execute([$id]);
    }

    public function simpleDelete($request, $response, $args): void {
        $val = $_POST['value'];
        $new = explode('_', $val);
        $id = $new[1];
        $query = Database::connection()->prepare('UPDATE doctors_form SET status = ? WHERE id = ?');
        $query->execute(['deleted', $id]);
    }

    public function fullDelete($request, $response, $args): void {
        $val = $_POST['value'];
        $new = explode('_', $val);
        $id = $new[1];
        $query = Database::connection()->prepare('DELETE FROM doctors_form WHERE id = ?');
        $query->execute([$id]);
    }
}