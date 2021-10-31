# Start the dev environment
.PHONY: dev
dev:
	docker-compose up

.PHONY: clean
clean:
	rm -rf ./var
	rm -rf ./public/uploads