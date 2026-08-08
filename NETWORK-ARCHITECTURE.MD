<!-- markdownlint-disable MD013 -->
<!-- cspell:ignore Chubes datamachine extrachill Imagify Lightbox Mediavine multisite revisioned worktree -->

# Extra Chill Network Architecture

Extra Chill runs one WordPress multisite network with nine active sites. WordPress
provides the shared runtime; repositories retain authority over their own data,
permissions, product behavior, and public contracts.

This document is a factual inventory and ownership map. It is not a dependency
allowlist, a central architecture scanner, or a specification for future work.

## Snapshot Metadata

| Field | Value |
| --- | --- |
| Generated | 2026-08-08 21:07:36 UTC |
| WordPress runtime | 7.0.3 |
| Homeboy runtime | 0.327.5+018b5a7a52b9 |
| Network | Extra Chill Sites |
| Active sites | 9 |
| Network-active plugins | 27 |
| Active theme | Extra Chill (`extrachill`) on all nine sites |
| GitHub evidence cutoff | Merged work and default branches visible on 2026-08-08 |

The inventory was rebuilt from the live production runtime without changing it:

- `wp site list` supplied the multisite IDs and URLs.
- `wp plugin list --status=active-network` supplied the network plugin inventory.
- `wp --url=<site> plugin list --status=active` supplied each site's additional plugins.
- `wp --url=<site> theme list --status=active` confirmed the theme on every site.
- `wp --url=<site> eval 'array_keys( wp_get_abilities() )'` confirmed the current owner ability surfaces.
- `/var/www/extrachill.com/wp-content/uploads/datamachine-files/network/NETWORK.md`, generated at 2026-08-08 21:03:42 UTC, supplied the composed nine-site names and roles.
- Merged audit pull requests and repository default branches supplied ownership and contract evidence.
- `homeboy review audit --help` and Homeboy's merged audit work supplied the current generic detection contract.

This is a point-in-time, manually reviewed snapshot. Before relying on inventory
details after the generated timestamp, rerun the commands above and compare the
result with the composed `NETWORK.md`. Architecture rules remain authoritative in
the repository that owns the affected behavior.

## Live Network

WordPress users are shared across the multisite network. Media remains site-local.
All nine sites currently use the Extra Chill theme, with site and network plugins
adding the product-specific behavior.

| Blog ID | Site | Current role | Additional site-active plugins |
| ---: | --- | --- | --- |
| 1 | [extrachill.com](https://extrachill.com/) | Music publication and network home | AI Provider for Claude Code; Co-Authors Plus; Data Machine Code; Data Machine Editor; Data Machine Socials; Extra Chill AI Adventure; Extra Chill Blog; Extra Chill Contact; Extra Chill Content Blocks; Mediavine Control Panel |
| 2 | [community.extrachill.com](https://community.extrachill.com/) | Community forums | bbPress; Blocks Everywhere; Extra Chill Community; Extra Chill Content Blocks |
| 3 | [shop.extrachill.com](https://shop.extrachill.com/) | Commerce | Extra Chill Shop; WooCommerce |
| 4 | [artist.extrachill.com](https://artist.extrachill.com/) | Artist profiles and artist tools | Extra Chill Artist Platform |
| 7 | [events.extrachill.com](https://events.extrachill.com/) | Events, venues, and booking | Data Machine Events; Extra Chill Events; Mediavine Control Panel |
| 9 | [newsletter.extrachill.com](https://newsletter.extrachill.com/) | Newsletter operations | None beyond network-active plugins |
| 10 | [docs.extrachill.com](https://docs.extrachill.com/) | Documentation | Data Machine Code; Extra Chill Docs |
| 11 | [wire.extrachill.com](https://wire.extrachill.com/) | Festival Wire and news feeds | Data Machine Socials; Extra Chill News Wire; Mediavine Control Panel |
| 12 | [studio.extrachill.com](https://studio.extrachill.com/) | Editorial studio | Blocks Everywhere; Data Machine Socials; Extra Chill Studio; Intelligence |

## Network-Active Plugins

The exact network-active plugin titles reported by WordPress are grouped here for
readability. Grouping does not transfer ownership between repositories.

| Platform and product | Runtime and adapters | Infrastructure and editor support |
| --- | --- | --- |
| Data Machine | AI Provider for Anthropic | Chubes Gallery Lightbox |
| Data Machine Business | AI Provider for OpenAI | Easy WP SMTP |
| Data Machine Chat Bridge | Extra Chill API | Gutenberg |
| Extra Chill Analytics | Extra Chill CLI | HTML to Blocks Converter |
| Extra Chill Cache | Extra Chill Events Network Blocks | Imagify |
| Extra Chill Network | Extra Chill Roadie | Redis Object Cache |
| Extra Chill Newsletter | Frontend Agent Chat | Two Factor |
| Extra Chill SEO | wp-native Auth | Not applicable |
| Extra Chill Users | WP Codebox | Not applicable |
| ExtraChill Search | Not applicable | Not applicable |
| Extra Chill Admin Tools | Not applicable | Not applicable |

Extra Chill Admin Tools is an active retirement shell. Its former administrative
behavior belongs to the relevant domain owners; new behavior must not be added to
the shell.

## Architecture Layers

Dependencies point down this list. A generic layer does not name or special-case a
product above it, and a consumer does not reach into a sibling owner's internals.

### 1. WordPress, Abilities, and Agents Substrate

WordPress core owns multisite context, users, posts, taxonomies, REST primitives,
and the Abilities API. The live runtime exposes core abilities such as
`core/get-site-info` through `wp_get_abilities()` and the Abilities REST controllers.

[Agents API](https://github.com/Automattic/agents-api) provides generic agent
identity, access, conversation, task, workflow, approval, and tool-call contracts.
Data Machine currently loads its Composer-managed Agents API dependency when no
compatible standalone copy is active. The live `agents/*` abilities are substrate
capabilities, not Extra Chill product semantics.

### 2. Generic Platform Services

Generic services provide reusable operational capability while remaining ignorant
of Extra Chill domains:

| Owner | Current responsibility |
| --- | --- |
| [Data Machine](https://github.com/Extra-Chill/data-machine) | WordPress automation product: agents, flows, pipelines, jobs, handlers, memory, approvals, content operations, and `datamachine/*` abilities |
| [Data Machine Business](https://github.com/Extra-Chill/data-machine-business) | Analytics-provider, business-service, media-maintenance, and communication integrations |
| [Data Machine Socials](https://github.com/Extra-Chill/data-machine-socials) | Social account, publishing, reading, engagement, and delivery contracts |
| [Data Machine Code](https://github.com/Extra-Chill/data-machine-code) | Repository, managed worktree, GitHub, and coding workspace contracts |
| [Data Machine Chat Bridge](https://github.com/Extra-Chill/data-machine-chat-bridge) | Generic external chat transport queue and delivery contracts |
| [WP Codebox](https://github.com/Automattic/wp-codebox) | Disposable WordPress coding and browser-contained sandbox contracts |
| [Frontend Agent Chat](https://github.com/Automattic/frontend-agent-chat) | Generic frontend agent chat interface |
| Intelligence | Retrieval, corpus, and wiki capabilities used by Studio; the installed repository is not publicly linkable |

These repositories own their service contracts. Extensions add providers or
adapters through those contracts; they do not make the generic service aware of a
specific Extra Chill product.

### 3. Domain Owners

A domain owner owns its storage, authorization, invariants, and public operations.
The live runtime confirms owner abilities for analytics, users, newsletters,
community, commerce, artists, events, documentation, and other site-scoped domains.

| Domain | Owner repository | Public boundary examples |
| --- | --- | --- |
| Network foundation | [Extra Chill Network](https://github.com/Extra-Chill/extrachill-network) | Network administration, shared policy, experiment and network operations |
| Identity and user state | [Extra Chill Users](https://github.com/Extra-Chill/extrachill-users) | User, onboarding, profile, moderation, subscription, notification, and access abilities |
| Analytics | [Extra Chill Analytics](https://github.com/Extra-Chill/extrachill-analytics) | Event tracking and aggregate reporting abilities |
| Newsletter | [Extra Chill Newsletter](https://github.com/Extra-Chill/extrachill-newsletter) | Subscription, campaign, settings, and reporting abilities |
| Community | [Extra Chill Community](https://github.com/Extra-Chill/extrachill-community) | Forum, topic, reply, voting, draft, and community reporting abilities |
| Commerce | [Extra Chill Shop](https://github.com/Extra-Chill/extrachill-shop) | Product, order, shipping, refund, and Stripe-facing abilities |
| Artists | [Extra Chill Artist Platform](https://github.com/Extra-Chill/extrachill-artist-platform) | Artist projections, roster, relationship, links, subscriber, and permission abilities |
| Events and venues | [Extra Chill Events](https://github.com/Extra-Chill/extrachill-events) | Event projections, venue membership, booking, settlement, local-support, and vendor abilities |
| Event ingestion and quality | [Data Machine Events](https://github.com/Extra-Chill/data-machine-events) | Event and venue import, query, geocoding, deduplication, and quality abilities |
| Publication | [Extra Chill Blog](https://github.com/Extra-Chill/extrachill-blog) | Main-site presentation and public festival projections |
| News wire | [Extra Chill News Wire](https://github.com/Extra-Chill/extrachill-news-wire) | Wire content and bounded activity projections |
| Search | [ExtraChill Search](https://github.com/Extra-Chill/extrachill-search) | Network search behavior and `extrachill/multisite-search` |
| SEO | [Extra Chill SEO](https://github.com/Extra-Chill/extrachill-seo) | SEO analysis, configuration, indexing, sitemap, and redirect abilities |
| Documentation | [Extra Chill Docs](https://github.com/Extra-Chill/extrachill-docs) | Documentation presentation and document upsert ability |
| Editorial blocks | [Extra Chill Content Blocks](https://github.com/Extra-Chill/extrachill-content-blocks) | Reusable editorial and interactive blocks |
| Contact | [Extra Chill Contact](https://github.com/Extra-Chill/extrachill-contact) | Contact submission ability and product-owned side effects |
| Studio | [Extra Chill Studio](https://github.com/Extra-Chill/extrachill-studio) | Editorial composition and Studio-specific workflows |

Public abilities are the default cross-repository operation boundary. A documented
public service, hook, package export, or WordPress core API is also valid when the
owner defines that contract. Another repository must not load physical sibling
paths, instantiate sibling-internal classes, query a foreign table, or duplicate an
owner's authorization and product rules.

Cross-site execution does not transfer ownership. An adapter may enter the owner's
site context, call the owner's public operation, and restore the original multisite
context. The owner still validates and executes the behavior.

### 4. Adapters

Adapters translate an owner contract for a transport or consumer. They may own
transport authentication, rate limiting, route affinity, argument projection,
output normalization, and presentation, but not the backing product semantics.

| Adapter | Boundary |
| --- | --- |
| [Extra Chill API](https://github.com/Extra-Chill/extrachill-api) | REST adapter for owner abilities and WordPress services; it does not own domain data or business logic |
| [Extra Chill CLI](https://github.com/Extra-Chill/extrachill-cli) | Operator-facing WP-CLI composition over owner abilities; commands bootstrap the owner site rather than loading sibling internals |
| [Extra Chill Roadie](https://github.com/Extra-Chill/extrachill-roadie) | Extra Chill tool and role adapter for Frontend Agent Chat; resolves product actions through owner contracts |
| [Extra Chill Events Network Blocks](https://github.com/Extra-Chill/extrachill-events) | Network distribution adapter for public Events-owned blocks without loading the full Events product runtime everywhere |

REST and ability schemas that expose the same operation require parity tests in the
adapter repository. Intentional transport-only fields or owner-only inputs must be
explicit and justified there.

### 5. Frontend Composition

The [Extra Chill theme](https://github.com/Extra-Chill/extrachill) supplies the
shared WordPress presentation shell on every site. Site plugins compose their own
templates, blocks, and data into that shell.

[Extra Chill Tokens](https://github.com/Extra-Chill/extrachill-tokens) owns shared
design tokens. [Extra Chill Components](https://github.com/Extra-Chill/extrachill-components)
publishes stable compiled component, type, CSS, and retained Sass contracts.
[Blocks Everywhere](https://github.com/Extra-Chill/blocks-everywhere) provides the
generic embedded Gutenberg editor runtime. Product plugins provide editor settings,
blocks, and domain behavior through public package and WordPress contracts rather
than adding consumer branches to the generic editor.

## Enforcement and Evidence

Homeboy provides generic detection. `homeboy review audit --profile architecture`
can detect configured layer ownership drift, and its detector remains product and
ecosystem agnostic. The component configuration and repository tests define what a
specific product owns. Homeboy does not own a central Extra Chill product allowlist.

Representative merged audit work:

- [Data Machine #3061](https://github.com/Extra-Chill/data-machine/pull/3061) exposed revisioned public pipeline configuration contracts.
- [Extra Chill Events #616](https://github.com/Extra-Chill/extrachill-events/pull/616) removed private Data Machine table and option coupling in favor of those contracts.
- [Extra Chill CLI #131](https://github.com/Extra-Chill/extrachill-cli/pull/131) replaced sibling-internal loading with owner-site ability bootstrap.
- [Extra Chill API #154](https://github.com/Extra-Chill/extrachill-api/pull/154) added repository-local REST-to-ability schema parity detection.
- [Blocks Everywhere #127](https://github.com/Extra-Chill/blocks-everywhere/pull/127) isolated embedded editor settings while keeping the generic runtime consumer-neutral.
- [Extra Chill Components #25](https://github.com/Extra-Chill/extrachill-components/pull/25) published a stable compiled package contract based on verified consumers.
- [Homeboy #11160](https://github.com/Extra-Chill/homeboy/pull/11160) activated configurable layer ownership rules.
- [Homeboy #5021](https://github.com/Extra-Chill/homeboy/pull/5021) moved language and ecosystem semantics out of generic detector implementations and into extension or component configuration.

Representative repository-local contracts and checks:

- [Data Machine ability boundary smoke](https://github.com/Extra-Chill/data-machine/blob/main/tests/ability-boundary-helpers-smoke.php)
- [Data Machine pipeline configuration tests](https://github.com/Extra-Chill/data-machine/blob/main/tests/Unit/Abilities/PipelineConfigurationAbilitiesTest.php)
- [Extra Chill Events canonical adapter contracts](https://github.com/Extra-Chill/extrachill-events/blob/main/tests/Unit/Abilities/CanonicalAdapterContractsTest.php)
- [Extra Chill Events multisite schema integration](https://github.com/Extra-Chill/extrachill-events/blob/main/tests/MySQLIntegration/BookingSchemaMultisiteTest.php)
- [Extra Chill API route and ability parity test](https://github.com/Extra-Chill/extrachill-api/blob/main/tests/Unit/routes/AbilityRouteSchemaParityTest.php)
- [Extra Chill CLI owner-site ability test](https://github.com/Extra-Chill/extrachill-cli/blob/main/tests/OwnerSiteAbilityTest.php)
- [Extra Chill Roadie owner capability smoke](https://github.com/Extra-Chill/extrachill-roadie/blob/main/tests/artist-owner-capabilities-smoke.php)
- [Blocks Everywhere editor settings test](https://github.com/Extra-Chill/blocks-everywhere/blob/trunk/src/editor/settings.test.ts)
- [Extra Chill Components package contract test](https://github.com/Extra-Chill/extrachill-components/blob/main/test/package-contract.test.mjs)
- [Homeboy layer ownership detector](https://github.com/Extra-Chill/homeboy/blob/main/crates/homeboy-code-audit/src/detectors/layer_ownership.rs)

New architecture constraints belong beside the code and contract they protect.
Organization documentation may link to those checks and summarize their direction;
it must not duplicate their product allowlists or become a second scanner.
