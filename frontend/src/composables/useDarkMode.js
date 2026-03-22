import { ref } from "vue";

const isDark = ref(false);

// Initialise from localStorage or system preference and immediately apply to
// the DOM. This runs once at module load time (synchronously), so the correct
// class is in place before the first Vue render.
if (typeof window !== "undefined") {
  const saved = localStorage.getItem("theme");
  isDark.value =
    saved === "dark" ||
    (!saved && window.matchMedia("(prefers-color-scheme: dark)").matches);

  if (isDark.value) {
    document.documentElement.classList.add("dark");
  }
}

export function useDarkMode() {
  function toggleDark() {
    isDark.value = !isDark.value;

    const { classList } = document.documentElement;
    if (isDark.value) {
      classList.add("dark");
      localStorage.setItem("theme", "dark");
    } else {
      classList.remove("dark");
      localStorage.setItem("theme", "light");
    }
  }

  return {
    isDark,
    toggleDark,
  };
}
