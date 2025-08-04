import { describe, it, expect, vi, beforeEach } from "vitest";
import { setActivePinia, createPinia } from "pinia";
import { useClientStore } from "../clientStore";

global.fetch = vi.fn();

describe("clientStore.uploadCSV", () => {
    let store: ReturnType<typeof useClientStore>;

    beforeEach(() => {
        setActivePinia(createPinia());
        store = useClientStore();

        document.head.innerHTML = `<meta name="csrf-token" content="mock-token">`;

        vi.clearAllMocks();
    });

    it("uploads a CSV file and calls updateClientData", async () => {
        const mockFile = new File(["name,data"], "clients.csv", {
            type: "text/csv",
        });

        const mockResponse = {
            ok: true,
            json: vi.fn().mockResolvedValue({ data: [{ id: 1 }] }),
        };

        const updateSpy = vi.spyOn(store, "updateClientData");

        (fetch as any).mockResolvedValue(mockResponse);

        await store.uploadCSV(mockFile);

        expect(fetch).toHaveBeenCalledWith(
            "/api/upload-csv",
            expect.any(Object)
        );
        expect(updateSpy).toHaveBeenCalledWith([{ id: 1 }]);
        expect(store.error.error_upload).toBeNull();
    });

    it("sets error if file is null", async () => {
        const warnSpy = vi.spyOn(console, "warn").mockImplementation(() => {});
        await store.uploadCSV(null);
        expect(warnSpy).toHaveBeenCalledWith("No file selected");
    });

    it("sets error on failed fetch", async () => {
        (fetch as any).mockRejectedValue(new Error("Network error"));
        const mockFile = new File(["test"], "clients.csv", {
            type: "text/csv",
        });

        await store.uploadCSV(mockFile);

        expect(store.error.error_upload).toBe(
            "Failed to upload client data, please try again"
        );
    });
});
