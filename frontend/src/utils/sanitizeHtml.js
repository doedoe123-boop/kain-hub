const ALLOWED_TAGS = new Set(["A", "BR", "EM", "I", "LI", "OL", "P", "STRONG", "UL"]);
const ALLOWED_ATTRIBUTES = {
  A: new Set(["href", "target", "rel"]),
};

function isSafeHref(value) {
  return /^(https?:|mailto:|tel:)/i.test(value);
}

export function sanitizeHtml(input) {
  if (!input || typeof input !== "string") {
    return "";
  }

  if (typeof window === "undefined" || typeof DOMParser === "undefined") {
    return input;
  }

  const parser = new DOMParser();
  const document = parser.parseFromString(`<div>${input}</div>`, "text/html");
  const root = document.body.firstElementChild;

  if (!root) {
    return "";
  }

  const sanitizeNode = (node) => {
    const children = Array.from(node.childNodes);

    children.forEach((child) => {
      if (child.nodeType === Node.ELEMENT_NODE) {
        const tagName = child.tagName.toUpperCase();

        if (!ALLOWED_TAGS.has(tagName)) {
          while (child.firstChild) {
            node.insertBefore(child.firstChild, child);
          }
          node.removeChild(child);
          sanitizeNode(node);
          return;
        }

        Array.from(child.attributes).forEach((attribute) => {
          const name = attribute.name.toLowerCase();
          const allowed = ALLOWED_ATTRIBUTES[tagName] ?? new Set();

          if (name.startsWith("on") || name === "style" || !allowed.has(attribute.name)) {
            child.removeAttribute(attribute.name);
          }
        });

        if (tagName === "A") {
          const href = child.getAttribute("href")?.trim() ?? "";
          if (!href || !isSafeHref(href)) {
            child.removeAttribute("href");
          }

          if (child.getAttribute("target") === "_blank") {
            child.setAttribute("rel", "noopener noreferrer");
          } else {
            child.removeAttribute("target");
            child.removeAttribute("rel");
          }
        }
      }

      sanitizeNode(child);
    });
  };

  sanitizeNode(root);

  return root.innerHTML;
}
