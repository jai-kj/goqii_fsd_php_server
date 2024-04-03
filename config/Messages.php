<?php

class Messages
{
    // Success messages
    const SERVER_STATUS_SUCCESS = "Server up and running with database connection established successfully";
    const USERS_LIST_SUCCESS = "Users list fetched successfully";
    const USER_FETCH_SUCCESS = "User details fetched successfully";
    
    // Failure messages
    const DB_CONNECTION_FAILED = "Database connection failed";
    const ROUTE_NOT_FOUND = "Route not found";
    const INVALID_METHOD = "Invalid http method used";
    const USER_NOT_FOUND = "User details not found";
    const INVALID_USER_ID = "User id must be a string and always be provided";
}
