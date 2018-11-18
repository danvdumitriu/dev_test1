<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;

class EndpointTest extends TestCase
{

    public function isValidTree($data) {
        if(!is_array($data)) return "Data is not array";
        if(!isset($data["treeData"])) return "Not set 'treeData'";

        if(count($data["treeData"])) {
            $first_element = reset($data["treeData"]);
            if(!is_array($first_element)) return "Element of 'treeData' is not array";
            if(!isset($first_element["name"])) return "Node does not have 'name' index";
            if(!isset($first_element["title"])) return "Node does not have 'title' index";
            if(!isset($first_element["expanded"])) return "Node does not have 'expanded' index";
            if(!isset($first_element["children"])) return "Node does not have 'children' index";
        }

        return true;
    }

    public function authTestUser() {
        $user = User::find(1);
        $this->be($user);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReadTreeResponse()
    {
        $response = $this->get('/api/tree');
        $response->assertStatus(200);
    }

    public function testReadTreeStructure()
    {
        $response = $this->get('/api/tree');
        $data = $response->getOriginalContent();

        $this->assertTrue($this->isValidTree($data));
    }

    public function testReadTreeStructureAuthUser()
    {
        $this->authTestUser();
        $response = $this->get('/api/tree');
        $data = $response->getOriginalContent();

        $this->assertTrue($this->isValidTree($data));
    }

    public function testWriteTreeNoAuthResponse()
    {
        $response = $this->post('/api/tree');

        $response->assertStatus(400);
    }

    public function testWriteTreeNoAuthMessage()
    {
        $response = $this->post('/api/tree');

        $error = $response->getOriginalContent();
        $this->assertEquals($error["error"],"Missing authentication params");
    }

    public function testWriteAuthNoData()
    {
        $this->authTestUser();
        $response = $this->post('/api/tree');

        $error = $response->getOriginalContent();
        $this->assertEquals($error["error"],"Missing 'treeData'");
    }

    public function testWriteWithData()
    {
        $this->authTestUser();

        $response = $this->get('/api/tree');
        $data = $response->getOriginalContent();

        $response = $this->post('/api/tree',$data);

        $this->assertTrue($this->isValidTree($response->getOriginalContent()));
    }
}
