<?php
/**
 * MessageFailuresTest.php
 *
 * PHP version 5.6+
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package tests\unit
 */

namespace tests\unit;

use sweelix\sendgrid\Mailer;
use sweelix\sendgrid\Message;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Test node basic functions
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package tests\unit
 * @since XXX
 */
class MessageFailuresTest extends TestCase
{

    public function setUp()
    {
        $this->mockApplication([
            'components' => [
                'email' => $this->createTestEmailComponent()
            ]
        ]);
    }

    public function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    protected function createTestEmailComponent()
    {
        // create component with token
        $component = new Mailer([
        ]);
        return $component;
    }

    /**
     * @return string test file path.
     */
    protected function getTestFilePath()
    {
        return Yii::getAlias('@test/runtime') . DIRECTORY_SEPARATOR . basename(get_class($this)) . '_' . getmypid();
    }

    /**
     * @return Message test message instance.
     */
    protected function createTestMessage()
    {
        return $this->createTestEmailComponent()->compose();
    }


    public function testBasicSend()
    {
        $message = $this->createTestMessage();
        $message->setFrom(SENDGRID_FROM);
        $message->setTo(SENDGRID_TO);
        $message->setSubject('Yii sendgrid test message');
        $message->setTextBody('Yii sendgrid test body');
        $this->expectException(InvalidConfigException::class);
        $message->send();
    }

    public function testTemplateSend()
    {
        $message = $this->createTestMessage();
        $message->setFrom(SENDGRID_FROM)
            ->setTo(SENDGRID_TO)
            ->setTemplateId(SENDGRID_TEMPLATE)
            ->setTemplateModel([
                'templateName' => 'test',
                'userName' => 'Mr test'
            ]);
        $this->expectException(InvalidConfigException::class);
        $message->send();
    }
}
