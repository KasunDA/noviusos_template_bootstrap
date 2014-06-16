<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$display_img = 'inline-block';
$display_img_small = 'inline-block';
$display_title = 'block';
$display_title_small = 'inline-block';
$id_text = 'title';

switch ($config['header']['type']) {
    case 'title':
        $display_img = 'none';
        $id_text = 'titleonly';
        $display_img_small = 'none';
        $str_title_small = '<span class="title_small_only">'.$config['header']['title'].'</span>';
        break;

    case 'image':
        $display_title = 'none';
        $display_title_small = 'none';
        break;

    case 'both':
        break;
}

$sitename = $config['header']['title'];

$str_img = '<div id="header-logo" class="image " style="display: '.
    $display_img.';" > <img src="'.$config['header']['logo_url'].'"></div>';
$str_img_small = '<div id="header-logo-small" class="image_small"> <img src="'.
    $config['header']['logo_url'].'"></div>';
$str_title_small = '<div id="header-title-small" class="title_small">'.$sitename.'</div>';
$str_title = '<div id="header-title" style="display: '.
    $display_title.';font-size: 20px;line-height: 20px;">'.$sitename.'</div>';
$str_baseline = '<div id="header-baseline" style="display: '.
    $display_title.';font-size: 13px;">'.$config['header']['baseline'].'</div>';

$top = '-50px';

if (!$dom_id) {
    switch ($config['header']['type']) {
        case 'text':
            $str_img = '';
            $id_text = 'titleonly';
            $str_img_small = '';
            $str_title_small = '<span class="title_small_only">'.$config['header']['title'].'</span>';
            break;

        case 'image':
            $str_title = '';
            $str_title_small = '';
            break;

        case 'both':
            break;
    }
}

$path_img = 'static/apps/noviusos_template_bootstrap/img/';

$depth = 3;
$top = '-72px';

$style_fixed  = '';

if ($config['header']['fixed']) {
    $style_fixed = 'header-fixed';
}
?>
<div class="head_content <?= $style_fixed ?>">
    <nav class="navbar navbar-inverse " role="navigation">

        <div class="navbar-header">

            <a class="navbar-brand" id="sitename"
               href="<?= \Nos\Tools_Url::context(\Nos\Nos::main_controller()->getPage()->get_context()) ?>"
                ><?= $str_img_small ?><?= $str_title_small ?></a>
            <button class="navbar-toggle collapsed right" data-target=".navbar-collapse" data-toggle="collapse"
                    type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="container collapse navbar-collapse">
<?php
if ($depth > 0) {
    $tpvar = \Nos\Nos::main_controller()->getTemplateVariation();
    $menu = $tpvar->menus->principal;
    if (empty($menu)) {
        $menu = \Nos\Menu\Model_Menu::buildFromPages(\Nos\Nos::main_controller()->getContext());
    }
    echo $menu->html(array(
        'view' => 'noviusos_template_bootstrap::'.$template.'/menu_header_driver',
        'id' => 'list-menu',
        'class' => 'nav navbar-nav navbar-right'
    ));
}
?>
        </div>

    </nav>
    <div id="header" class="nav-logo customisable title_header" style="top :<?=$top?> ; z-index: auto">
        <a href="#" style="display: inline-block;">
            <?= $str_img ?>
            <div class="<?=$id_text?>">
                <?= $str_title ?>
                <?= $str_baseline ?>
            </div>
        </a>
    </div>
</div>





