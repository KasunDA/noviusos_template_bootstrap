<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'formats' => array(
        'bootstrap-carousel' => array(
            'view' => 'noviusos_template_bootstrap::slideshow/slideshow',
            'label' => __('Bootstrap carousel'),
            'config' => array(
                'slides_with_link' => true,
                'slides_preview' => true,
                'width' => '414',
                'height' => '300',
                'class' => 'slide-small',
                'js' => array(
                    'jquery' => 'static/apps/noviusos_template_bootstrap/vendor/js/jquery.min.js',
                    'bootstrap' => 'static/apps/noviusos_template_bootstrap/vendor/bootstrap/js/bootstrap.min.js',
                    ),
                'css' => array(
                    'bootstrap' => 'static/apps/noviusos_template_bootstrap/vendor/bootstrap/css/skin/Bootstrap.css',
                ),
            ),
        ),
    ),
);
