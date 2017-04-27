<?php
define('APP_PATH', '/var/www/html/wekain-angular/'); // path scripts
define('MAP_IMGS_URL', 'http://192.168.1.9:8000/img/maps/'); // path scripts
define('MAP_IMGS_PATH', '/var/www/html/wekain-angular/public/img/maps/'); // path scripts
//define('POSTGRES_IP', '127.0.0.1'); // ip postgres local
define('POSTGRES_IP', '127.0.0.1'); // ip postgres local
//define('POSTGRES_USER', 'dexter'); // user postgres local
define('POSTGRES_USER', 'user'); // user postgres local
//define('POSTGRES_PASS', '0112358'); // pass postgres local
define('POSTGRES_PASS', 'user'); // pass postgres local
define('POSTGRES_DB', 'wekain'); // bdd postgres local
//define('POSTGRES_DB', 'gadm'); // bdd postgres local

define('POSTGRES_CONN', "host=".POSTGRES_IP." port=5432 dbname=".POSTGRES_DB." user=".POSTGRES_USER." password=".POSTGRES_PASS); // IP postgres local

function qryPoint($lat=0, $lng=0){
    $map = new mapObj(APP_PATH."mapas/global.map");

    $l = $map->getLayerByName('gadm');
    $l->set('connection',POSTGRES_CONN);

    $punto = new pointObj();
    $punto->setXY($lng,$lat);
    //$punto->x=$lng;
    //$punto->y=$lat;
    try{
        $l->queryByPoint($punto,MS_SINGLE,-1);
    }catch(Exception $er){
        $l->close();
        $map->freequery(-1);
        return [];
    }
    //$punto->setXY($lat,$lng);

    $n_resultados =$l->getNumResults();
    $resultado = [];
    for ($i=0; $i<$l->getNumResults();$i++){
        $s = $l->getShape($l->getResult($i));
        $resultado = $s->values;
        break;
    }
    $l->close();
    return $resultado;
}

function qryImage($capa="gadm_nivel0",$parametros=[],$render=true,$width=500,$height=400,$img_format="png"){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "recorte de GADM");
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);

    $map->setExtent(-180.000015, -90.000000, 180.000000, 83.627419);
    // set the size of the image in number of pixels
    // width, height
    $map->setSize($width, $height);

    //$map->setExtent(-92.008966, -5.016157,-75.187147, 1.681835);
    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $filtro = "";
    $i=0;
    foreach ($parametros as $key => $value) {
        if($i==0){
            $filtro .= $key.'='.$value.' ';
        }else{
            $filtro .= 'AND '.$key.'='.$value.' ';
        }
        $i++;
    }
    $layer->setFilter($filtro);
    $layer->set("classitem", "id");
    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        $provincia_class=ms_newClassObj($layer);
        $provincia_class->set("name", $s->values['id']);
        $provincia_class->setExpression((int)$s->values['id']);
        $provincia_style=ms_newStyleObj($provincia_class);
        $provincia_style->color->setRGB(250,0, 0);
        $provincia_style->outlinecolor->setRGB(0,0,0);
        $ex = $s->bounds;
        //$map->setExtent($ex->minx, $ex->miny, $ex->maxx, $ex->maxy);
    }

    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}


function pais_explorado_random($capa="gadm_nivel0",$model,$render=true,$width=500,$height=400,$img_format="png"){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Pais Explorado");
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);

    // set the size of the image in number of pixels
    // width, height
    $map->setSize($width, $height);

    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);

    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $filtro = "id_0 = ".$model->id_0;
    //$layer->setFilter($filtro);
    $layer->set("classitem", "id_0");

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        //$res = $this->verificar_explorado($s,$lugares_explorados,$nivel);
        $res = FALSE;
        //echo '<hr />RES.'.$res; rand(0,1)
        if($s->values['id_0']==$model->id_0){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_engli']);
            $class->setExpression((int)$s->values['id_0']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }else{
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_engli']);
            $class->setExpression((int)$s->values['id_0']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //die();
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagepng($image);
    }else{
        return $url;
    }
}

function paises_explorados_random($capa="gadm_nivel0",$render=true,$width=500,$height=400,$img_format="png"){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Pais Explorado");
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);
    // set the size of the image in number of pixels
    // width, height
    $map->setSize($width, $height);

    
    //$map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);
    $map->setExtent(-180.000015, -90.000000, 180.000000, 83.627419);
    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $layer->set("classitem", "id_0");

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        //$res = $this->verificar_explorado($s,$lugares_explorados,$nivel);
        $res = rand(0,1);
        //echo '<hr />RES.'.$res; 
        if($res){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_engli']);
            $class->setExpression((int)$s->values['id_0']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }else{
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_engli']);
            $class->setExpression((int)$s->values['id_0']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //die();
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagepng($image);
    }else{
        return $url;
    }
}

function provincias_exploradas_random($capa="gadm_nivel1",$model,$render=true,$width=500,$height=400,$img_format="png"){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Provincias Exploradas ".ucfirst($model->pais));
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);

    // set the size of the image in number of pixels
    // width, height
    $map->setSize($width, $height);

    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);

    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $filtro = "id_0 = ".$model->id_0;
    $layer->setFilter($filtro);
    $layer->set("classitem", "id_1");

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        //$res = $this->verificar_explorado($s,$lugares_explorados,$nivel);
        $res = rand(0,1);
        //echo '<hr />RES.'.$res;// 
        if($res){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_1']);
            $class->setExpression((int)$s->values['id_1']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }else{
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_1']);
            $class->setExpression((int)$s->values['id_1']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}

function verificar_explorado($shape,$ids,$nivel){
    /*switch ($nivel) {
        case 1:
            if($shape->values['id_0'])
            break;
        
        default:
            # code...
            break;
    }*/
}

function area_explored_by_ids($capa="gadm_nivel1",$model,$render=true,$width=500,$height=400,$img_format="png",$ids_explorados,$mapfile_sub=""){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Area Explorada ".ucfirst($mapfile_sub));
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);
    $metadata = $map->web->metadata;
    $metadata->set('wms_srs','EPSG:4326');
    $metadata->set('wms_enable_request','*');
    
    // set the size of the image in number of pixels
    $map->setSize($width, $height);
    
    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);
    //filtros para la capa
    $filtro="";
    $classitem="id_0";
    $nameitem="name_1";
    switch ($capa) {
        case 'gadm_nivel1':
            $filtro = "id_0 = ".$model->id_0;
            $classitem="id_1";
            $nameitem="name_1";
        break;
        case 'gadm_nivel2':
            $filtro = "id_0 = ".$model->id_0. ' AND id_1 = '.$model->id_1;
            $classitem="id_2";
            $nameitem="name_2";
        break;
        case 'gadm_nivel3':
            $filtro = "id_0 = ".$model->id_0. ' AND id_1 = '.$model->id_1. ' AND id_2 = '.$model->id_2;
            $classitem="id_3";
            $nameitem="name_3";
        break;
    }
    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $layer->setFilter($filtro);
    $layer->set("classitem", $classitem);

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        if(in_array($s->values['id'], $ids_explorados)){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values[$nameitem]);
            $class->setExpression((int)$s->values[$classitem]);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    $map->save(APP_PATH."mapas/autogenerated/area_explored_by_ids$mapfile_sub.map");
    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}
function area_not_explored_by_ids($capa="gadm_nivel1",$model,$render=true,$width=500,$height=400,$img_format="png",$ids_explorados,$mapfile_sub=""){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Area Explorada ".ucfirst($mapfile_sub));
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);
    $metadata = $map->web->metadata;
    $metadata->set('wms_srs','EPSG:4326');
    $metadata->set('wms_enable_request','*');
    
    // set the size of the image in number of pixels
    $map->setSize($width, $height);
    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);
    //filtros para la capa
    $filtro="";
    $classitem="id_0";
    $nameitem="name_1";
    switch ($capa) {
        case 'gadm_nivel1':
            $filtro = "id_0 = ".$model->id_0;
            $classitem="id_1";
            $nameitem="name_1";
        break;
        case 'gadm_nivel2':
            $filtro = "id_0 = ".$model->id_0. ' AND id_1 = '.$model->id_1;
            $classitem="id_2";
            $nameitem="name_2";
        break;
        case 'gadm_nivel3':
            $filtro = "id_0 = ".$model->id_0. ' AND id_1 = '.$model->id_1. ' AND id_2 = '.$model->id_2;
            $classitem="id_3";
            $nameitem="name_3";
        break;
    }
    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $layer->setFilter($filtro);
    $layer->set("classitem", $classitem);

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        if(!in_array($s->values['id'], $ids_explorados)){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values[$nameitem]);
            $class->setExpression((int)$s->values[$classitem]);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    $map->save(APP_PATH."mapas/autogenerated/area_not_explored_by_ids$mapfile_sub.map");
    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}

function area_by_ids($capa="gadm_nivel1",$model,$render=true,$width=500,$height=400,$img_format="png",$ids_explorados,$mapfile_sub=""){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Area Explorada ".ucfirst($mapfile_sub));
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);
    $metadata = $map->web->metadata;
    $metadata->set('wms_srs','EPSG:4326');
    $metadata->set('wms_enable_request','*');
    
    // set the size of the image in number of pixels
    $map->setSize($width, $height);
    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);
    //filtros para la capa
    $filtro="";
    $classitem="id_0";
    $nameitem="name_1";
    switch ($capa) {
        case 'gadm_nivel1':
            $filtro = "id_0 = ".$model->id_0;
            $classitem="id_1";
            $nameitem="name_1";
        break;
        case 'gadm_nivel2':
            $filtro = "id_0 = ".$model->id_0. ' AND id_1 = '.$model->id_1;
            $classitem="id_2";
            $nameitem="name_2";
        break;
        case 'gadm_nivel3':
            $filtro = "id_0 = ".$model->id_0. ' AND id_1 = '.$model->id_1. ' AND id_2 = '.$model->id_2;
            $classitem="id_3";
            $nameitem="name_3";
        break;
    }
    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $layer->setFilter($filtro);
    $layer->set("classitem", $classitem);

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        if(in_array($s->values['id'], $ids_explorados)){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values[$nameitem]);
            $class->setExpression((int)$s->values[$classitem]);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }else{
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values[$nameitem]);
            $class->setExpression((int)$s->values[$classitem]);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    $map->save(APP_PATH."mapas/autogenerated/area_total_by_ids$mapfile_sub.map");
    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}

function cantones_explorados_random($capa="gadm_nivel2",$model,$render=true,$width=500,$height=400,$img_format="png"){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Cantones Explorados ".ucfirst($model->provincia));
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);

    // set the size of the image in number of pixels
    // width, height
    $map->setSize($width, $height);

    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);

    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $filtro = "id_0 = ".$model->id_0. 'AND id_1 = '.$model->id_1;
    $layer->setFilter($filtro);
    $layer->set("classitem", "id_2");

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        //$res = $this->verificar_explorado($s,$lugares_explorados,$nivel);
        $res = rand(0,1);
        //echo '<hr />RES.'.$res;// 
        if($res){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_2']);
            $class->setExpression((int)$s->values['id_2']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }else{
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_2']);
            $class->setExpression((int)$s->values['id_2']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}

function parroquias_exploradas_random($capa="gadm_nivel3",$model,$render=true,$width=500,$height=400,$img_format="png"){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Cantones Explorados ".ucfirst($model->provincia));
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);

    // set the size of the image in number of pixels
    // width, height
    $map->setSize($width, $height);

    //dd($model);
    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);

    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $filtro = "id_0 = ".$model->id_0. 'AND id_1 = '.$model->id_1.' AND id_2 = '.$model->id_2;
    $layer->setFilter($filtro);
    $layer->set("classitem", "id_3");

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        //$res = $this->verificar_explorado($s,$lugares_explorados,$nivel);
        $res = rand(0,1);
        //echo '<hr />RES.'.$res;// 
        if($res){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_3']);
            $class->setExpression((int)$s->values['id_3']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }else{
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_3']);
            $class->setExpression((int)$s->values['id_3']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}

function parroquias_exploradas_by_ids($capa="gadm_nivel3",$model,$render=true,$width=500,$height=400,$img_format="png",$ids_explorados){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "Cantones Explorados ".ucfirst($model->provincia));
    $map->selectoutputformat($img_format);

    $map->web->set("imageurl", MAP_IMGS_URL);
    $map->web->set("imagepath", MAP_IMGS_PATH);

    // set the size of the image in number of pixels
    // width, height
    $map->setSize($width, $height);

    //dd($model);
    $map->setExtent($model->minx, $model->miny, $model->maxx, $model->maxy);

    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');
    $filtro = "id_0 = ".$model->id_0. 'AND id_1 = '.$model->id_1.' AND id_2 = '.$model->id_2;
    $layer->setFilter($filtro);
    $layer->set("classitem", "id_3");

    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    while ($s= $layer->nextShape())
    {
        if(in_array($s->values['id'], $ids_explorados)){
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_3']);
            $class->setExpression((int)$s->values['id_3']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(0,255,0);
            $style->outlinecolor->setRGB(0,0,0);
        }else{
            $class=ms_newClassObj($layer);
            $class->set("name", $s->values['name_3']);
            $class->setExpression((int)$s->values['id_3']);
            $style=ms_newStyleObj($class);
            $style->color->setRGB(250,0, 0);
            $style->outlinecolor->setRGB(0,0,0);
        }
    }
    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();
    if($render){
        //echo $url;
        $image= ImageCreateFromPng($url);
        header("Content-type: image/png");

        // output image to the browser
        imagePng($image);
    }else{
        return $url;
    }
}

/**
 * Duvuelve una imagen con un mapa de ecuador y su division politica,
 * los niveles de division politica son 3:
 * -0: provincias
 * -1: cantones
 * -2: parroquias
 * @param  integer $nivel Nivel de division politica
 * @return image/png   Mapa de Ecuador
 */
function mapa_explorado($nivel=0,$pais_id=68){

    $lugares_explorados =array();

    $map = ms_newMapObj(FCPATH.'mapas/ec.map');
    $map->set("name", "recorte de GADM");

    $map->web->set("imageurl",FCPATH."tmp/");
    $map->web->set("imagepath", FCPATH."tmp/");

    // set the size of the image in number of pixels
    // width, height
    $map->setSize(500, 400);

    $map->setExtent(-92.008966, -5.016157,-75.187147, 1.681835);


    $layer = ms_newLayerObj($map);
    $layer->set('name','provincias');
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    //$layer->set('connection',"dbname='ecuador' host='".POSTGRES_IP."' port=5432 user='dexter' password='0112358' sslmode=disable");
    //$layer->set('connection',"dbname='ecuador' host='".POSTGRES_IP."' port=5432 user='postgres' password='postgres' sslmode=disable");
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM gadm using unique objectid');
    $filtro = "id_0=".$pais_id;
    $layer->setFilter($filtro);
    $layer->set("classitem", "id_3");




    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);


    while ($s= $layer->nextShape())
    {
        //$res = $this->verificar_explorado($s,$lugares_explorados,$nivel);
        $res = FALSE;
        //echo '<hr />RES.'.$res;
        if($res){
            $exploradas_class=ms_newClassObj($layer);
            $exploradas_class->set("name", $s->values['name_3']);
            $exploradas_class->setExpression((int)$s->values['id_3']);
            $exploradas_style=ms_newStyleObj($exploradas_class);
            $exploradas_style->color->setRGB(0,255,0);
            $exploradas_style->outlinecolor->setRGB(0,0,0);
        }else{
            $provincia_class=ms_newClassObj($layer);
            $provincia_class->set("name", $s->values['name_3']);
            $provincia_class->setExpression((int)$s->values['id_3']);
            $provincia_style=ms_newStyleObj($provincia_class);
            $provincia_style->color->setRGB(250,0, 0);
            $provincia_style->outlinecolor->setRGB(0,0,0);
        }
    }

    $layer->close();

    // draw map
    $image = $map->draw();

    // output map
    $url = $image->saveWebImage();

    //echo $url;
    $image= ImageCreateFromPng($url);
     header("Content-type: image/png");

    // output image to the browser
    imagePng($image);
}

function extraer_extent($capa="paises",$parametros=[]){
    $map = ms_newMapObj(APP_PATH.'mapas/generador.map');
    $map->set("name", "recorte de GADM");

    $map->setExtent(-180.000015, -90.000000, 180.000000, 83.627419);

    $layer = ms_newLayerObj($map);
    $layer->set('name',$capa);
    $layer->set('status',MS_ON);
    $layer->setProjection("init=epsg:4326");
    $layer->set('type',MS_LAYER_POLYGON);
    $layer->setConnectionType(MS_POSTGIS);
    //$layer->set('connection',"dbname='ecuador' host='".POSTGRES_IP."' port=5432 user='dexter' password='0112358' sslmode=disable");
    $layer->set('connection', POSTGRES_CONN);
    $layer->set('data','geom FROM '.$capa.' using unique objectid');

    //echo $map->extent->minx.' --- '.$map->extent->miny.' --- '.$map->extent->maxx.' --- '.$map->extent->maxy;
    
    $filtro = "";
    $i=0;
    foreach ($parametros as $key => $value) {
        if($i==0){
            $filtro .= $key.'='.$value.' ';
        }else{
            $filtro .= 'AND '.$key.'='.$value.' ';
        }
        $i++;
    }
    $layer->setFilter($filtro);
    $status = $layer->open();
    $status = $layer->whichShapes($map->extent);

    $resultado = array();

    while ($s= $layer->nextShape())
    {

        $ex = $s->bounds;
        $centro = $s->getCentroid();

        //echo $ex->minx.' --- '.$ex->miny.' --- '.$ex->maxx.' --- '.$ex->maxy;
        $resultado=array(
            'minx'=>$ex->minx,
            'miny'=>$ex->miny,
            'maxx'=>$ex->maxx,
            'maxy'=>$ex->maxy,
            'lat'=>$centro->y,
            'lng'=>$centro->x
        );

    }
    $layer->close();

    return $resultado;
}