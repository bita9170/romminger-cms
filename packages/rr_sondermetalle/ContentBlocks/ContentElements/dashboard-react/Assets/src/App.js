import React, { useState } from "react";
import UserMenu from "./components/UserMenu";

function App() {
  const [count, setCount] = useState(0);

  return (
    <div>
    <UserMenu />
    </div>
  );
}

export default App;
