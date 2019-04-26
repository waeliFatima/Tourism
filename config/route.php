<?php

//we will manage route here..
Router::register('/',"userController.show");
Router::register('update/{name}',"userController.update");

