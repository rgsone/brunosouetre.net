.DEFAULT_GOAL := help
.PHONY: help
help: ## Affiche l'aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: clear-debug
clear-debug: ## Nettoie les fichiers créés par clockwork/debugbar
	rm -rvf storage/clockwork/*
	rm -rvf storage/debugbar/*

.PHONY: clear-uploaded-thumbs
clear-uploaded-thumbs: ## Supprime tous les thumbnails du dossier upload
	rm -rvf storage/app/resized/*
	find storage/app/uploads/ -type f -iname "thumb_*.*" -delete

.PHONY: clear-cache
clear-cache: ## Nettoie entiérement le cache
	rm -rvf storage/cms/cache/*
	rm -rvf storage/cms/twig/*
	rm -rvf storage/framework/cache/*
	rm -rvf storage/framework/views/*
	rm -rvf storage/temp/public/*

.PHONY: clear-sessions
clear-sessions: ## Supprime les sessions
	rm -rvf storage/framework/sessions/*

.PHONY: clear-galeries-thumbs
clear-galeries-thumbs: ## Supprime les thumbnails générés par les galeries
	rm -rvf galeries/*/thumb/

.PHONY: dev-site
dev-site: ## Lance le serveur de dev pour le site
	cd front/site && npm run dev

.PHONY: build-front-site
build-front-site: ## Build les fichiers front pour le site
	cd front/site && npm run build

.PHONY: build-dist
build-dist: ## Créer le dossier dist prêt à être déployé
	make build-front-site
	rm -rf dist/ ; mkdir dist/
	cp -ar bootstrap/ config/ modules/ plugins/ themes/ vendor/ .env.prod .htaccess.prod apple-touch-icon.png composer.json favicon.ico icon.svg icon-192.png icon-512.png index.php manifest.webmanifest robots.txt dist/
	mv dist/.htaccess.prod dist/.htaccess ; mv dist/.env.prod dist/.env
	rm -rf dist/plugins/bedard/ # remove dev plugins
	rm -f dist/vendor/bin/*

.PHONY: pack-dist
pack-dist: ## pack dist with tar
	tar -cvf distrib.tar dist/
