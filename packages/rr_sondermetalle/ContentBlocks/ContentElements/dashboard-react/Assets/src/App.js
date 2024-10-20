import React, { useState } from "react";

function App() {
  const [count, setCount] = useState(0);

  return (
    <div className="p-4 d-flex justify-content-center">
      <button class="btn btn-success" onClick={() => setCount(count + 1)}>
        You pressed me {count} times
      </button>
    </div>
  );
}

export default App;
