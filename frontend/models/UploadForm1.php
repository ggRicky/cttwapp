<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for upload a CSV file type.
 *
 */

class UploadForm1 extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        // 2019-09-23 : checkExtensionByMimeType property. Whether to check file type (extension) with mime-type.
        // If extension produced by file mime-type check differs from uploaded file extension, the file will be
        // considered as invalid.
        //
        // This property must be set to false because the revision of the file type against
        // the file extension may fail due to a Yii2 bug.
        //
        // Issue : Wrong mime type detection for CSV files #6148
        // Url   : https://github.com/yiisoft/yii2/issues/6148
        // File  : 2019-09-23_ARTICULO_Wrong_Mime_Type_Detection_for_CSV_Files_yiisoft_yii2.pdf
        return [
            [['file'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'csv', 'skipOnEmpty' => false,],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => Yii::t('app', 'Selector de Archivos').' : ',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            try {
                $file_name = '/imported_article_list.'; // The default name used to import data from a CSV file.
                $this->file->saveAs(Yii::getAlias('@webroot').Yii::getAlias('@uploads').$file_name.$this->file->extension);
                return true;
            } catch (\Exception $e) {
                // File wasn't uploaded correctly
                switch ($e->getCode()) {
                    case 2 :
                        $message = Yii::t('app','El sistema no puede encontrar el archivo especificado').'.';
                        break;
                    case 3 :
                        $message = Yii::t('app','El sistema no puede encontrar la ruta especificada').'.';
                        break;
                    case 5 :
                        $message = Yii::t('app','Acceso Denegado').'.';
                        break;
                    default :
                        $message = $e->getMessage();
                }
                Yii::$app->session->setFlash('error', nl2br(Yii::t('app','El archivo no fue cargado correctamente, por favor intente de nuevo').'.'."\n".$message));
                return false;
            }
        } else {
            return false;
        }
    }
}
