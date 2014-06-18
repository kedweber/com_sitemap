<?/**
* ComSitemap
*
* @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
*/

defined('KOOWA') or die('Restricted Access'); ?>

<?= @helper('behavior.mootools'); ?>

<script src="media://lib_koowa/js/koowa.js" />

<div class="row-fluid">
    <form action="" method="get" class="-koowa-grid" data-toolbar=".toolbar-list">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="text-align: center;" width="1">
                    <?= @helper('grid.checkall')?>
                </th>
                <th>
                    <?= @helper('grid.sort', array('column' => 'package', 'title' => @text('PACKAGE'))); ?>
                </th>
                <th>
                    <?= @helper('grid.sort', array('column' => 'name', 'title' => @text('NAME'))); ?>
                </th>
                <th>
                    <?= @helper('grid.sort', array('column' => 'enabled', 'title' => @text('PUBLISHED'))); ?>
                </th>
                <th>
                    <?= @text('Owner'); ?>
                </th>
                <th>
                    <?= @helper('grid.sort', array('column' => 'created_on', 'title' => @text('Date'))); ?>
                </th>
                <th>
                    <?= @helper('grid.sort', array('column' => 'id', 'title' => @text('ID'))); ?>
                </th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <td colspan="9">
                    <?= @helper('paginator.pagination', array('total' => $total)) ?>
                </td>
            </tr>
            </tfoot>

            <tbody>
            <? foreach ($configs as $config) : ?>
                <tr>
                    <td style="text-align: center;">
                        <?= @helper('grid.checkbox', array('row' => $config))?>
                    </td>
                    <td>
                        <a href="<?= @route('view=config&id='.$config->id); ?>">
                            <?= @escape($config->package); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= @route('view=config&id='.$config->id); ?>">
                            <?= @escape($config->name); ?>
                        </a>
                    </td>
                    <td>
                        <?= @helper('grid.enable', array('row' => $config)); ?>
                    </td>
                    <td>
                        <?= $config->created_by_name; ?>
                    </td>
                    <td>
                        <?= @helper('date.humanize', array('date' => $config->created_on)) ?>
                    </td>
                    <td>
                        <?= $config->id; ?>
                    </td>
                </tr>
            <? endforeach; ?>

            <? if (!count($configs)) : ?>
                <tr>
                    <td colspan="9" align="center" style="text-align: center;">
                        <?= @text('NO_ITEMS'); ?>
                    </td>
                </tr>
            <? endif; ?>
            </tbody>
        </table>
    </form>
</div>