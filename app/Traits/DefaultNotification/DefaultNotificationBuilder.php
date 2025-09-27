<?php

namespace App\Traits\DefaultNotification;

trait DefaultNotificationBuilder
{
    public function setType(string $notification_type): self
    {
        $this->notification_type = $notification_type;
        return $this;
    }

    public function setTypeName(string $type_name): self
    {
        $this->type_name = $type_name;
        return $this;
    }

    public function setTypeText(string $type_text): self
    {
        $this->type_text = $type_text;
        return $this;
    }

    public function setSMS(bool $send_sms): self
    {
        $this->send_sms = $send_sms;
        return $this;
    }

    public function setEditSMS(bool $edit_sms): self
    {
        $this->edit_sms = $edit_sms;
        return $this;
    }

    public function setSMSText(string $sms_text): self
    {
        $this->sms_text = $sms_text;
        return $this;
    }

    public function setEmail(bool $send_email): self
    {
        $this->send_email = $send_email;
        return $this;
    }

    public function setEditEmail(bool $edit_email): self
    {
        $this->edit_email = $edit_email;
        return $this;
    }

    public function setEmailHeader(string $email_header): self
    {
        $this->email_header = $email_header;
        return $this;
    }

    public function setEmailFooter(string $email_footer): self
    {
        $this->email_footer = $email_footer;
        return $this;
    }

    public function setEmailText(string $email_text): self
    {
        $this->email_text = $email_text;
        return $this;
    }

    public function setReader(string $reader): self
    {
        $this->reader = $reader;
        return $this;
    }
}
