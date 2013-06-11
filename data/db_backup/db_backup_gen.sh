#!/bin/bash

#dump all table names except users
pg_dump vb_drupal -U postgres -T 'Users' > safe_full_copy.sql

