<?php

class AlbumSeeder extends Seeder
{

    public function run()
    {
        $this->db->truncate('album');

        $data = ["order" => 0, "name" => "hkep", "label" => "hkep", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 0, "parentId" => 1, "name" => "hkep001", "label" => "hkep-hkep001", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 1, "parentId" => 1, "name" => "hkep002", "label" => "hkep-hkep002", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 1, "name" => "cp1987", "label" => "cp1987", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 0, "parentId" => 4, "name" => "cp1987 01", "label" => "cp1987-001", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 1, "parentId" => 4, "name" => "cp1987 02", "label" => "cp1987-002", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 2, "parentId" => 4, "name" => "cp1987 03", "label" => "cp1987-003", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 2, "name" => "ebook", "label" => "ebookset", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 0, "parentId" => 8, "name" => "ebook 001", "label" => "ebook001", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 1, "parentId" => 8, "name" => "ebook 002", "label" => "ebook002", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 2, "parentId" => 8, "name" => "ebook 003", "label" => "ebook003", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 3, "parentId" => 8, "name" => "ebook 004", "label" => "ebook004", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

        $data = ["order" => 3, "name" => "hgdev", "label" => "hg", "intro" => strip_tags(file_get_contents("http://loripsum.net/api/2/short/headers"))];
        $this->db->insert("album", $data);

    }
}