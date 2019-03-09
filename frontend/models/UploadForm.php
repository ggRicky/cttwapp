<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for upload file process.
 *
 * @property string $imageFile
 */

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'image',
                'skipOnEmpty' => false,   //  Whether the validation can be skipped if the input is empty. Defaults to false, which means the input is required.
                'extensions'  => 'png, jpg',
                'minWidth'    => 100, 'maxWidth' => 1000,
                'minHeight'   => 100, 'maxHeight' => 1000,],
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

    public function upload($id=null)
    {
        if ($this->validate()) {
            try {
                $this->file->saveAs(Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.(is_null($id)? PREFIX_IMG.date('Ymd_his'):PREFIX_IMG.$id).'.'.$this->file->extension);
                return true;
            } catch (\Exception $e) {
                // file wasn't uploaded correctly
                switch ($e->getCode()) {
                    case 2 :
                        $message = Yii::t('app','El sistema no puede encontrar el archivo especificado.');
                        break;
                    case 3 :
                        $message = Yii::t('app','El sistema no puede encontrar la ruta especificada.');
                        break;
                    case 5 :
                        $message = Yii::t('app','Acceso Denegado.');
                        break;
                    default :
                        $message = $e->getMessage();
                }
                Yii::$app->session->setFlash('error', nl2br("El archivo no fue cargado correctamente, por favor intente de nuevo.\n".$message));
                return false;
            }
        } else {
            return false;
        }
    }
}
