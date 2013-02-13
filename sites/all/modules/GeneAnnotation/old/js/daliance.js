  new Browser({
    chr:          '3R',
    viewStart:    10000000,
    viewEnd:      30030000,
    cookieKey:    'human',

    sources:     [{name:                 'Genome',      
                   uri:                  'http://treason.ebi.ac.uk:9000/das/agam_cap/',      
                   tier_type:            'sequence',
                   provides_entrypoints: true},
                  {name:                 'Genes',     
                   desc:                 'Gene structures from Ensembl 54',
                   uri:                  'http://treason.ebi.ac.uk:9000/das/agam_cap/',      
                   collapseSuperGroups:  false,
                   provides_karyotype:   false,
                   provides_search:      false},
                  {name:                 'MeDIP-seq',
                   uri:                  'http://www.ebi.ac.uk/das-srv/genomicdas/das/batman_seq_SP/'}],

    searchEndpoint: new DASSource('http://www.derkholm.net:8080/das/hsa_54_36p/'),
    browserLinks: {
        Ensembl: 'http://ncbi36.ensembl.org/Homo_sapiens/Location/View?r=${chr}:${start}-${end}',
        UCSC: 'http://genome.ucsc.edu/cgi-bin/hgTracks?db=hg18&position=chr${chr}:${start}-${end}',
    },

    forceWidth: 700
  });


