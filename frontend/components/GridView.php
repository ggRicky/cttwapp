<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 12/01/19
 * Time: 04:48 PM
 */

namespace frontend\components;

use yii\helpers\Html;

class GridView extends \yii\grid\GridView
{

    /**
     * Renders the data models for the grid view.
     * @return string the HTML code of table
     */
    public function renderItems()
    {
        $caption = $this->renderCaption();
        $columnGroup = $this->renderColumnGroup();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody = $this->renderTableBody();

        $tableFooter = false;
        $tableFooterAfterBody = false;

        if ($this->showFooter) {
            if ($this->placeFooterAfterBody) {
                $tableFooterAfterBody = $this->renderTableFooter();
            } else {
                $tableFooter = $this->renderTableFooter();
            }
        }

        $content = array_filter([
            $caption,
            $columnGroup,
            $tableHeader,
            $tableFooter,
            $tableBody,
            $tableFooterAfterBody,
        ]);

        // 2019-01-12 : Refactor 1
        // Add an HTML <div> tag to wrap the content of the GridView widget to enable the fixHeadTable add-on.

        // 2019-01-12 : Refactor 2
        // Add an HTML div tag to separate a line the content of the GridView widget from the information tags.
        return Html::tag('div',Html::tag('table', implode("\n", $content), $this->tableOptions),['id' =>'fixTableWrapper']).Html::tag('br');
    }

}