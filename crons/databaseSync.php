<?php 

/**
 * Script to save data to NoSQL db in case the web API goes down, 
 * will continuously update every 10 minutes to give at least 10
 * minutes between data sets, still need to figure out whether to 
 * go with couchDB or mongo for this
 */