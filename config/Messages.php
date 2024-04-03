<?php

class Messages
{
    // Success messages
    const SERVER_STATUS_SUCCESS = "Server up and running with database connection established successfully";
    const USERS_LIST_SUCCESS = "Users list fetched successfully";
    const USER_FETCH_SUCCESS = "User details fetched successfully";
    const USER_INSERT_SUCCESS = "User added successfully";
    const USER_UPDATE_SUCCESS = "User updated successfully";
    
    // Failure messages
    const DB_CONNECTION_FAILED = "Database connection failed";
    const ROUTE_NOT_FOUND = "Route not found";
    const INVALID_METHOD = "Invalid http method used";
    const EMPTY_REQ_BODY = "Empty request body passed";
    const USER_NOT_FOUND = "User details not found";
    const INVALID_USER_ID = "User id must be a string and always be provided";
    const INCOMPLETE_USER_INSERT_BODY = "Please provide name, email and date of birth of the new user";
    const INVALID_USER_NAME = "Invalid user name provided";
    const INVALID_USER_EMAIL = "Invalid user email provided";
    const INVALID_USER_DOB = "Invalid user date of birth provided";
    const USER_INSERT_FAILURE = "Failed to add new user";
    const INCOMPLETE_USER_UPDATE_BODY = "Please provide name, email or date of birth of the user to update";
    const USER_UPDATE_FAILURE = "Failed to update user details";
}
