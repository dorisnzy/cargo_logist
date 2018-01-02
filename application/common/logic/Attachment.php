<?php
// +----------------------------------------------------------------------
// | 货物运送系统
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: dorisnzy <dorisnzy@163.com>
// +----------------------------------------------------------------------
// | Date: 2017-12-30
// +----------------------------------------------------------------------

namespace app\common\logic;

use app\common\logic\Base;

/**
 * 附件管理
 */
class Attachment extends Base
{
	//设置数据表（不含前缀)
    protected $name = 'attachment';
    // 数据表主键 复合主键使用数组定义 不设置则自动获取
    protected $pk = 'attachment_id';

    protected $file_dir = ROOT_PATH . 'public' . DS . 'uploads';

	/**
	 * 多图片上传
	 */
	public function uploadAll(){
	    $files = request()->file('file');
	    foreach($files as $file){
	        $validate = [
	        	'ext'=>'jpg,png',
	        ];
	        $info = $file->validate($validate)->move($this->file_dir);
	        if($info){
	            // 成功上传后 获取上传信息
	            return $this->saveAttachment($info);
	        }else{
	            // 上传失败获取错误信息
	            $this->setError($file->getError());
	            return false;
	        }    
	    }
	}

	/**
	 * 单个图片上传
	 */
	public function uploadOne()
	{	
		$file = request()->file('file');
		
        $validate = [
        	'ext'=>'jpg,png,'
        ];
        $info = $file->validate($validate)->move($this->file_dir);
        if($info){
            $attachment_id = $this->saveAttachment($info);
            if (!$attachment_id) {
            	return false;
            }
            return $attachment_id;
        }else{
            // 上传失败获取错误信息
            $this->setError($file->getError());
            return false;
        }    
	}

	/**
	 * 保存附件
	 *
	 * @param  string  $info       附件对象
	 * @param  integer $scene_type 附件使用场景类型（attachment_user表中的scene_type字段）
	 *
	 * @return [type]              [description]
	 */
	protected function saveAttachment($info = '')
	{
		// 接收数据
		$data['name']        = $info->getFilename(); //获取文件名
		$data['path']        = $info->getPath(); //不带文件名的文件路径
		$data['url']         = str_replace(ROOT_PATH . 'public', '', $info->getPathname()); //全路径
		$data['ext']         = $info->getExtension(); //文件扩展名
		$data['md5']         = $info->md5();
		$data['sha1']        = $info->sha1();
		$data['savename']    = $info->getBasename(); //获取无路径的basename
		$data['create_time'] = time(); //创建时间
        $data['update_time'] = time(); //更新时间
        $data['size']        = $info->getSize(); //文件大小，单位字节
        $data['owner']       = $info->getOwner(); //文件拥有者
        $data['location']    = ROOT_PATH . 'public'; // 附件存储位置
        $data['ip']		 	 = request()->ip(); // 附件上传IP
        $data['mime']        = $info->getMime(); // 文件mime类型
        $data['sort']        = 100;

		$res = db('attachment')->insertGetId($data);

		if (!$res) {
			$this->setError('上传失败');
			return false;
		}

		return $res;
	}

	/**
	 * 保存附件与用户关联
	 *
	 * @param  integer $uid           用户ID
	 * @param  integer $attachment_id 附件ID
	 * @param  integer $scene_type    场景值
	 * @param  string $extra         场景扩展字段
	 *
	 * @return boolean                成功-true，失败-false
	 */
	public function saveUserAttachment($uid, $attachment_id, $scene_type, $extra = '')
	{
		$user_attach_data['uid'] 			= $uid;
		$user_attach_data['attachment_id']  = $attachment_id;
		$user_attach_data['scene_type']     = $scene_type;
		$user_attach_data['extra']     		= $extra;

		$res = db('attachment_user')->insert($user_attach_data);
		if (!$res) {
			$this->setError('保存附件失败');
			return false;
		}
	}

	/**
	 * 获取附件地址
	 *
	 * @param  integer $uid           用户ID
	 * @param  integer $attachment_id 附件ID
	 * @param  integer $scene_type    场景值
	 * @param  string $extra         场景扩展字段
	 *
	 * @return  array              附件信息
	 */
	public function getUrls($uid = 0, $scene_type = 0, $extra = '')
	{
		$map = [];
		if ($uid) {
			$map['uid'] 		= $uid;
		}
		if ($scene_type) {
			$map['scene_type'] 	= $scene_type;
		}
		if ($extra) {
			$map['extra'] 		= $extra;
		}
		$attachment_id = db('attachment_user')->where($map)->column('attachment_id');
		$attachment_id = array_filter($attachment_id);
		$attachment_id = array_unique($attachment_id);

		return $this->where(['attachment_id' => ['in', $attachment_id]])->column('url');
	}
}

