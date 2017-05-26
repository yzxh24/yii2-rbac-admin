<?php
/**
 * 附件上传表单
 * User: wangtao
 * Date: 2017/3/31
 * Time: 10:50
 */

namespace backend\forms;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use backend\models\Attachments as Entity;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $upload_file;

    public function rules()
    {
        return [
            ['upload_file', 'file',
                'extensions' => 'psd, zip, rar, png, jpg, jpeg',
                'checkExtensionByMimeType' => true,
                'maxSize' => 20000000,
                'tooBig' => '上传的文件大小不能超过20M'],
        ];
    }

    public function generateRandomNumber()
    {
        return strtoupper(dechex(date('m'))).date('d') . substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
    }

    /**
     * 确定是否为图片
     * @return integer
     */
    public function isImage()
    {
        if (in_array(strtolower($this->upload_file->getExtension()), ['jpg', 'png', 'jpeg'])) {
            return Entity::IS_IMAGE;
        }

        return Entity::IS_NOT_IMAGE;
    }

    /**
     * 上传文件
     * @param int $uid
     * @param string $moduleName
     * @return array
     */
    public function upload($uid, $moduleName = 'activity')
    {
        $fileName = $this->generateRandomNumber() . '.' . $this->upload_file->getExtension();
        $entity = new Entity();
        $entity->create_date = date('Y-m-d');
        $saveFile = $entity->getSavePath() . $fileName;

        if ($this->upload_file->saveAs($saveFile))
        {
            $entity->subject = $this->upload_file->getBaseName();
            $entity->uid = $uid;
            $entity->is_image = $this->isImage();
            $entity->file_size = $this->upload_file->size;
            $entity->file_type = FileHelper::getMimeType($saveFile);
            $entity->attach_name = $fileName;
            $entity->module_name = $moduleName;
            $entity->save();

            return [
                'error' => 0,
                'url' => $entity->getUrl(),
                'file_path' => $entity->getFileUrl(),
                'file_id' => $entity->id
            ];
        }

        // 上传失败
        return ['error' => 1, 'message' => "上传失败"];
    }
}
