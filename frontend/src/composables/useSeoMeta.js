import { computed } from "vue";
import { useHead } from "@unhead/vue";
import { useSeoStore } from "@/stores/seo";

/**
 * Inject page-level SEO meta tags using @unhead/vue.
 *
 * All values are wrapped in computed() so they update reactively when
 * the global SEO store finishes loading after fetchSettings().
 *
 * Fields fall back through: page-specific → store/property/product-level → global defaults.
 *
 * @param {object|import('vue').Ref} options  Plain options object or a ref/computed to a plain object.
 * @param {string|null} [options.title]        Page-specific title (without site name suffix).
 * @param {string|null} [options.description]  Meta description override.
 * @param {string|null} [options.ogImage]      Absolute URL of the Open Graph image.
 * @param {string}      [options.ogType]       OG type (default: 'website').
 * @param {string|null} [options.canonical]    Canonical URL for this page.
 * @param {boolean}     [options.noIndex]      Set true to add noindex,nofollow.
 */
export function useSeoMeta(options = {}) {
  const seo = useSeoStore();

  // Support both a plain object and a reactive ref/computed object.
  const get = (key, fallback = null) =>
    computed(() => {
      const o = typeof options.value !== "undefined" ? options.value : options;
      return o[key] ?? fallback;
    });

  const titleOpt = get("title");
  const descriptionOpt = get("description");
  const ogImageOpt = get("ogImage");
  const ogType = get("ogType", "website");
  const canonical = get("canonical");
  const noIndex = get("noIndex", false);

  const resolvedTitle = computed(() => seo.buildTitle(titleOpt.value));
  const resolvedDescription = computed(
    () => descriptionOpt.value || seo.defaultDescription || "",
  );
  const resolvedOgImage = computed(
    () => ogImageOpt.value || seo.defaultOgImage || "",
  );

  useHead({
    title: resolvedTitle,
    meta: computed(() => [
      { name: "description", content: resolvedDescription.value },

      // Open Graph
      { property: "og:title", content: resolvedTitle.value },
      { property: "og:description", content: resolvedDescription.value },
      { property: "og:type", content: ogType.value },
      ...(resolvedOgImage.value
        ? [{ property: "og:image", content: resolvedOgImage.value }]
        : []),

      // Twitter / X card
      { name: "twitter:card", content: seo.twitterCard },
      { name: "twitter:title", content: resolvedTitle.value },
      { name: "twitter:description", content: resolvedDescription.value },
      ...(seo.twitterSite
        ? [
            {
              name: "twitter:site",
              content: `@${seo.twitterSite.replace(/^@/, "")}`,
            },
          ]
        : []),
      ...(resolvedOgImage.value
        ? [{ name: "twitter:image", content: resolvedOgImage.value }]
        : []),

      ...(noIndex.value
        ? [{ name: "robots", content: "noindex,nofollow" }]
        : []),
    ]),
    link: computed(() =>
      canonical.value ? [{ rel: "canonical", href: canonical.value }] : [],
    ),
  });
}
