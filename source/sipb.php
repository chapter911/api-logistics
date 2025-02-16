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
        $this->app->get($this->pattern, function (Request $request, Response $response) {
            $value_data = $request->getParsedBody();
            $no_spj = $value_data['no_spj'];

            $sql = "SELECT * FROM vw_sipb_hdr WHERE no_spj = '$no_spj'";
            $fetch = $this->db->query($sql)->fetchAll();
            if ($fetch) {
                $material = $this->db->query("SELECT * FROM vw_sipb_dtl WHERE no_spj = '$no_spj'")->fetchAll();
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
        });
    }

    private function getSPJ() {
        $this->app->get($this->pattern . "/{no_spj}", function (Request $request, Response $response, $args) {
            $value_data = $request->getParsedBody();
            $no_spj = $args['no_spj'];

            $sql = "SELECT * FROM vw_sipb_hdr WHERE no_spj = '$no_spj'";
            $fetch = $this->db->query($sql)->fetchAll();
            if ($fetch) {
                $material = $this->db->query("SELECT * FROM vw_sipb_dtl WHERE no_spj = '$no_spj'")->fetchAll();
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
        });
    }
}