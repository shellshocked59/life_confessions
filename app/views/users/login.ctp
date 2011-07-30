<?php
echo $session->flash('auth');
echo $this->Form->create('User', array('action' => 'login'));
?>
Email: 
<?php
echo $this->Form->input('email', array('label' => false));
?>
Password: 
<?php
echo $this->Form->input('password', array('label' => false));
echo $this->Form->end('Login');
?>