<?php
require_once(dirname(__FILE__) . '/service.php');

$solr = new Apache_Solr_Service();
$solr->setHost('127.0.0.1');
$solr->setPath('solr/test3');
$solr->setPort('8983');
if ($solr->ping()){
    try {
        
        
        //$solr->deleteByQuery('*:*'); //删除所有文档
        
        

        
        
        
        
        
        
//        $document = new Apache_Solr_Document();
//        $document->id = date('YmdHis') . uniqid(); //or something else suitably unique
//
////        $document->title = 'Some Title';
////        $document->content = 'Some content for this wonderful document. Blah blah blah.';
//
//        $document->name = '名' . date('YmdHis') . uniqid();
//        $document->password = 'password' . date('YmdHis') . uniqid();
//        $document->code = date('His');
//        
//        
//        $document->t6 = 232;
//        $document->setField('t2', '123');
//        $document->setField('t3', '1234');
//        $document->setField('t3', '12345');
//        
//        $document->addField('t4', '554');
//        $document->addField('t4', '565');
//        $document->addField('t4', '5423');
//        
//        $document->addField('t5', '5564');
//        $document->addField('t5', '5655');
//        $document->addField('t5', '54623');
//        
//        
//        $solr->addDocument($document); 	//if you're going to be adding documents in bulk using addDocuments
//                                        //with an array of documents is faster
//
//        $solr->commit(); //commit to see the deletes and the document
//        //$solr->optimize(); //'400' Status: Bad Request merges multiple segments into one
//        echo '完成';
        
        
        
        
        
        
        
        
        
        //and the one we all care about, search!
        //any other common or custom parameters to the request handler can go in the
        //optional 4th array argument.
//        $re = $solr->search('*:*', 0, 10, array('sort' => 'id desc'));
//        $data = $re->getRawResponse();
//        //string(253) "{ "responseHeader":{ "status":0, "QTime":1, "params":{ "q":"content:blah", "json.nl":"map", "start":"0", "sort":"id desc", "rows":"10", "wt":"json"}}, "response":{"numFound":0,"start":0,"docs":[] }} "
//        $data = json_decode($data, true);
//        $data = $data['response'];
//        var_dump($data);
        
        
        
//        $params = array('sort' => 'id desc');
//        $query = '*:*';
//        $re = $solr->search($query, 0, 10, $params);
//        $data = $re->getRawResponse();
//        $data = json_decode($data, true);
//        $data = $data['response'];
//        var_dump($data);   
        
        
        
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
}else{
    echo '链接失败';
}












