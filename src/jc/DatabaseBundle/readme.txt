To use functions in DQL, add them in config.yml > orm section :

    orm:
        auto_generate_proxy_classes: "%kernel.debug%"
        entity_managers:
            default:
                auto_mapping: true
                dql:
                    datetime_functions:
                        date: jc\DatabaseBundle\SQLFunction\Date
                        day: jc\DatabaseBundle\SQLFunction\Date
                        hour: jc\DatabaseBundle\SQLFunction\Hour
                        month: jc\DatabaseBundle\SQLFunction\Month
                        week: jc\DatabaseBundle\SQLFunction\Week
                        year: jc\DatabaseBundle\SQLFunction\Year
