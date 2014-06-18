<?
/**
* ComSitemap
*
* @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
*/

defined('KOOWA') or die('Restricted Access'); ?>
<?= @helper('behavior.mootools'); ?>
<?= @helper('behavior.keepalive'); ?>
<?= @helper('behavior.validator'); ?>

<script src="media://lib_koowa/js/koowa.js" />

<form action="" class="form-horizontal -koowa-form" method="post">
    <div class="row-fluid">
        <div class="span8">
            <fieldset>
                <legend><?= @text('CONTENT'); ?></legend>
                <div class="control-group">
                    <label class="control-label"><?= @text('PACKAGE'); ?></label>
                    <div class="controls">
                        <input class="span12 required" type="text" name="package" value="<?= @escape($config->package); ?>" placeholder="<?= @text('PACKAGE'); ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?= @text('NAME'); ?></label>
                    <div class="controls">
                        <input class="span12 required" type="text" name="name" value="<?= @escape($config->name); ?>" placeholder="<?= @text('NAME'); ?>" />
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="span4">
            <fieldset>
                <legend><?= @text('DETAILS'); ?></legend>
                <div class="control-group">
                    <label class="control-label"><?= @text('PUBLISHED'); ?></label>
                    <div class="controls">
                        <?= @helper('select.booleanlist', array('name' => 'enabled', 'selected' => $config->enabled)); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</form>