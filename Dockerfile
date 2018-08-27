FROM mycrm/base

COPY . /var/specs
WORKDIR /var/specs

# Config
ENTRYPOINT ["bin/behat"]