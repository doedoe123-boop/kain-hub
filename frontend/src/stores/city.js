import { defineStore } from "pinia";
import { ref, computed } from "vue";

const STORAGE_KEY_DETECTED = "negosyo_detected_city";
const STORAGE_KEY_SELECTED = "negosyo_selected_city";
const NOMINATIM_URL = "https://nominatim.openstreetmap.org/reverse";

/**
 * Grab-like city detection.
 *
 * Priority: manually selected city > geolocation-detected city > null (global)
 *
 * When activeCity is set, listing pages pre-filter to that city.
 * When results are sparse or null, pages fall back to global listings.
 */
export const useCityStore = defineStore("city", () => {
  const detectedCity = ref(localStorage.getItem(STORAGE_KEY_DETECTED) || null);
  const selectedCity = ref(localStorage.getItem(STORAGE_KEY_SELECTED) || null);
  const detecting = ref(false);
  const error = ref(null);

  /** The city currently in use — manual override wins over auto-detected. */
  const activeCity = computed(() => selectedCity.value || detectedCity.value);

  /**
   * Ask the browser for the user's location; reverse-geocode with Nominatim
   * and persist the resulting city name. Only runs once per session unless
   * `force` is true.
   */
  async function detectCity(force = false) {
    if (!force && detectedCity.value) {
      return;
    }

    if (!navigator.geolocation) {
      return;
    }

    detecting.value = true;
    error.value = null;

    try {
      const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject, {
          timeout: 8000,
          maximumAge: 300_000,
        });
      });

      const { latitude, longitude } = position.coords;

      const response = await fetch(
        `${NOMINATIM_URL}?lat=${latitude}&lon=${longitude}&format=json`,
        {
          headers: {
            "Accept-Language": "en",
            "User-Agent": "NegosyoHub/1.0",
          },
        },
      );

      if (!response.ok) {
        throw new Error("Nominatim request failed");
      }

      const data = await response.json();
      const city =
        data.address?.city ||
        data.address?.town ||
        data.address?.municipality ||
        data.address?.county ||
        null;

      if (city) {
        detectedCity.value = city;
        localStorage.setItem(STORAGE_KEY_DETECTED, city);
      }
    } catch {
      // Geolocation denied or network error — silently fall back to global
    } finally {
      detecting.value = false;
    }
  }

  /** Manually override the active city (user picks from input). */
  function setCity(city) {
    selectedCity.value = city;
    localStorage.setItem(STORAGE_KEY_SELECTED, city);
  }

  /** Clear the manual override; fall back to auto-detected or global. */
  function clearOverride() {
    selectedCity.value = null;
    localStorage.removeItem(STORAGE_KEY_SELECTED);
  }

  /** Remove all city data and browse globally. */
  function clearAll() {
    selectedCity.value = null;
    detectedCity.value = null;
    localStorage.removeItem(STORAGE_KEY_SELECTED);
    localStorage.removeItem(STORAGE_KEY_DETECTED);
  }

  return {
    detectedCity,
    selectedCity,
    detecting,
    error,
    activeCity,
    detectCity,
    setCity,
    clearOverride,
    clearAll,
  };
});
