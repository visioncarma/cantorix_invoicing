<?php
class AppError extends ErrorHandler {
    function youEvil() {
        $this->controller->set(array(
             'name' => __('You are an evil person', true)
         ));

        $this->__outputMessage('bad_user');
    }
}
?>