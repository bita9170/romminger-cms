import React from "react";

const RightInfoPanel = () => {
  return (
    <aside className="bg-gray-100 p-4 rounded-lg shadow-md md:w-64">

      <div className="mb-6">
        <h3 className="text-lg font-semibold">My Current Address</h3>
        <p>John Doe</p>
        <p>Berliner Straße, 10</p>
        <p>70123 Berlin</p>
        <p>Germany</p>
      </div>

      <div className="mb-6">
        <h3 className="text-lg font-semibold">Aktuelle Zahlungsart</h3>
        <p>Rechnung</p>
        <p className="text-sm text-gray-600">
          Bei Auswahl der Zahlungsart Rechnung erhalten Sie Ihre Bestellung...
        </p>
      </div>

      <div>
        <h3 className="text-lg font-semibold">Additional Info</h3>
        <p>Gutscheine</p>
        <p>Rabatte</p>
        <p>Versandkosten: €1.30</p>
        <p>Gesamtpreis: €38.99</p>
      </div>
    </aside>
  );
};

export default RightInfoPanel;
