#!/bin/bash


# dump data on live
ssh bella "psql -U postgres -c \"COPY blast_results to '/tmp/blast_results'; COPY blast_hits to '/tmp/blast_hits'; COPY blast_hsps to '/tmp/blast_hsps'; COPY xgrid_job_params to '/tmp/xgrid_job_params';\" vb_drupal"


# copy data from live to local machine
scp bella:/tmp/blast_* /tmp/
scp bella:/tmp/xgrid_job_params /tmp/


#delete local instance of this data
psql -U postgres -c "DELETE FROM blast_results;
DELETE FROM blast_hits;
DELETE FROM blast_hsps;
DELETE FROM xgrid_job_params;" vb_drupal


# import data on local instance
psql -U postgres -c "COPY blast_results from '/tmp/blast_results';
COPY blast_hits from '/tmp/blast_hits';
COPY blast_hsps from '/tmp/blast_hsps';
COPY xgrid_job_params from '/tmp/xgrid_job_params';" vb_drupal


# update local sequences
psql -U postgres -c "SELECT setval('blast_results_br_id_seq', (SELECT MAX(br_id) FROM blast_results));
SELECT setval('blast_hits_bh_id_seq', (SELECT MAX(bh_id) FROM blast_hits));
SELECT setval('blast_hsps_bs_id_seq', (SELECT MAX(bs_id) FROM blast_hsps));" vb_drupal



# clean up
rm /tmp/blast_*
rm /tmp/xgrid_job_params