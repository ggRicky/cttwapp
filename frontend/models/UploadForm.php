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
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'image',
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
            'imageFile' => Yii::t('app', 'Selector de Archivos').' : ',
        ];
    }

    public function upload($id=null)
    {
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.(is_null($id)? PREFIX_IMG.date('Ymd_his'):PREFIX_IMG.$id).'.'.$this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}