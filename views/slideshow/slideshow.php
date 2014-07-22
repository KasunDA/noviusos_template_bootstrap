<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$libs = array('js.jquery', 'js.bootstrap', 'css.bootstrap');
foreach ($libs as $lib) {
    $lib_url = \Arr::get($config, $lib, null);
    if (empty($lib_url)) {
        continue;
    }
    if (substr($lib, 0, 2) === 'js') {
        \Nos\Nos::main_controller()->addJavascript($lib_url, true);
    } else {
        \Nos\Nos::main_controller()->addCss($lib_url);

    }
}

\Nos\Nos::main_controller()->addJavascriptInline(\View::forge('noviusos_template_bootstrap::slideshow/javascript'));

?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">
        <?php
        $i = 0;
        foreach ($slideshow->images as $key => $image) {
            ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?= $key ?>"
                class="<?= $i ? "" : "active" ?>"></li>
        <?php
            $i++;
        }

        ?>
    </ol>
    <div class="carousel-inner">
        <?php
        $i = 0;
        foreach ($slideshow->images as $key => $image) {
            if (empty($image->medias->image)) {
                continue;
            }
            ?>

            <div class="item <?= $i ? "" : "active" ?>">
                <?php
                $img = $image->medias->image->htmlImgResized(
                    \Arr::get($config, 'width', 800),
                    \Arr::get($config, 'height', 600),
                    array(
                        'alt' => $image->slidimg_title,
                        'title' => $image->slidimg_title,
                        'style' => 'margin: 0 auto;',
                    )
                );
                    echo $img;
                ?>
                <div class="carousel-caption">
                    <?php
                    if (!empty($image->slidimg_title) || !empty($image->slidimg_description)) {
                        echo '<p class="flex-caption">';
                        if (!empty($image->slidimg_title)) {
                            echo '<strong>', htmlspecialchars($image->slidimg_title), '</strong><br />';
                        }
                        if (!empty($image->slidimg_description)) {
                            echo htmlspecialchars($image->slidimg_description);
                        }
                        echo '</p>';
                    }
                    ?>
                </div>
            </div>
        <?php
            $i++;
        }
        ?>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
