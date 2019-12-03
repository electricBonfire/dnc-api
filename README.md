# DNC API

## Formats

* JSON / JSON LD
* HYDRA

### Edit `./config/packages/api_platform.yml`

```yaml
api_platform:
    mapping:
        paths: ['%kernel.project_dir%/src/Entity']
    patch_formats:
        json: ['application/merge-patch+json']
    swagger:
        versions: [3]
    formats:
        html:
            mime_types:
                - text/html
        json:
            mime_types:
                - application/json
        jsonld:
            mime_types:
                - application/ld+json
        jsonhal:
            mime_types:
                - application/hal+json
        csv:
            mime_types:
                - text/csv
    collection:
        pagination:
            items_per_page: 1
```

# GraphQL

run 

* `docker exec -it dnc-api composer req webonyx/graphql-php`
* `docker exec -it dnc-api ./bin/console cache:clear`

* Go to http://localhost/api/graphql