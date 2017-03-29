<?php
if (!IN_MANAGER_MODE) {
    die('<h1>ERROR:</h1><p>Please use the MODx Content Manager instead of accessing this file directly.</p>');
}
$pid = 0;
//print_r($_GET);
if (isset($_GET['pid']) && (int)$_GET['pid'] > 0) {//создается документ новый
	$pid = $_GET['pid'];
}
if (isset($_GET['id']) && (int)$_GET['id'] > 0) {//документ уже создан и редактируется
	$id = (int)$_GET['id'];
	$pid = $modx->db->getValue("SELECT parent FROM " . $modx->getFullTableName("site_content"). " WHERE id={$id}");
}
if ($pid) {
	$tv = $modx->getTemplateVarOutput('image', $pid);
	$image = $tv['image'];
	if ($image && $image != '') {
		$image = MODX_SITE_URL . $image;
		$out .= '<script language="javascript" src="' . MODX_SITE_URL . 'assets/tvs/imagemap/jquery-canvas-area-draw/jquery.canvasAreaDraw.js"></script>';
		$out .= '<textarea id="tv' . $row['id'] . '" name="tv' . $row['id'] . '" cols="40" rows="15" onchange="documentDirty=true;" style="width:100%" data-image-url="' . $image . '"  class="canvas-area input-xxlarge">' . $row['value'] . '</textarea>';
	} else {
		$out .= 'В родительский документ не загружено изображение в TV с именем image либо данный TV-параметр не создан / не прикреплен к шаблону';
	}
} else {
	$out .= 'Произошла ошибка, не найден родительский документ';
}
echo $out;
