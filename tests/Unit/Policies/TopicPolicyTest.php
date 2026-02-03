<?php

namespace Tests\Unit\Policies;

use PHPUnit\Framework\TestCase;

use App\Models\Topic;
use App\Models\Course;
use App\Models\User;
use App\Models\Partner;
use App\Models\Role;

use App\Policies\TopicPolicy;
use Tests\Support\CreatePartners;

class TopicPolicyTest extends TestCase
{
    use CreatePartners;

    public function test_bt_user_manager_can_create_topic(){
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;

        $BT_Course = new Course();
        $BT_Course->setRelation('manager', $BT_Partner);

        $policy = new TopicPolicy();
        return $this->assertTrue($policy->create($BT_User, $BT_Course));
    }

    public function test_ssv_user_no_manager_course_cannot_create_topic(){
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun');
        $SSV_User = $SSV_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_Course = new Course();
        $BT_Course->setRelation('manager', $BT_Partner);

        $policy = new TopicPolicy();
        return $this->assertFalse($policy->create($SSV_User, $BT_Course));
    }

    public function test_pt_admin_no_manager_course_cannot_update_topic(){
        $PT_Partner = $this->makePartner('PT', 'Administrador');
        $PT_User = $PT_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_Course = new Course();
        $BT_Course->setRelation('manager', $BT_Partner);

        $BT_Topic = new Topic();
        $BT_Topic->setRelation('course', $BT_Course);

        $policy = new TopicPolicy();
        return $this->assertFalse($policy->update($PT_User, $BT_Topic, $BT_Course));
    }
}
