<?php
$seo = new \Model_Seo();
$s = \Uri::string();
if (empty($s))
    $s = '/';
$data = $seo->getByUrl($s);
?>

<title><?php echo $data['title']; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $data['description'] ?>">
<meta name="Keywords" content="<?php echo $data['keywords'] ?>"/>
<meta name="author" content="The Gitftp Team">
<link rel="canonical" href="<?php echo \Fuel\Core\Uri::current() ?>"/>
<link rel="icon" type="img/ico" href="<?php echo \Uri::base(); ?>favicon.ico">
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<meta name="robots" content="index,follow,noodp,noydir"/>
<meta property="og:title" content="<?php echo $data['title'] ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo \Fuel\Core\Uri::current() ?>"/>
<meta property="og:description" content="<?php echo $data['description'] ?>"/>
<meta property="og:site_name" content="<?php echo $data['title'] ?>"/>