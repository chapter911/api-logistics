<?php
use Slim\Http\Response;
use Slim\Http\Request;

class sipb extends Library {

    public function __construct($function)
    {
        parent::__construct();
        self::$function();
        return $this->app->run();
    }

    private function search() {
        $this->app->post($this->pattern, function (Request $request, Response $response) {
            $value_data = $request->getParsedBody();
            $no_sipb = $value_data['no_sipb'];

            $sql = "SELECT * FROM vw_sipb_hdr WHERE no_sipb = '$no_sipb'";
            $fetch = $this->db->query($sql)->fetchAll();
            if ($fetch) {
                $material = $this->db->query("SELECT * FROM vw_sipb_dtl WHERE no_sipb = '$no_sipb'")->fetchAll();
                $result['status']  = "success";
                $result['message'] = "berhasil mendapatkan data";
                $result['data']['header']    = $fetch;
                $result['data']['material']    = $material;
            } else {
                $result['status']  = "failed";
                $result['message'] = "gagal mendapatkan data";
                $result['data']    = null;
            }
            return $response->withJson($result, 200);
        })->add(parent::middleware());
    }
}