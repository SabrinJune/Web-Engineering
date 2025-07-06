let n = parseInt(prompt("Enter the number of Fibonacci terms:"));
    let fib = [0, 1];

    for (let i = 2; i < n; i++) {
      fib[i] = fib[i - 1] + fib[i - 2];
    }

    console.log("Fibonacci Series:");
    for (let i = 0; i < n; i++) {
      console.log(fib[i]);
    }

    const outputContainer = document.getElementById("Container");
    const colors = ['blue', 'green'];

    for (let i = 0; i < n; i++) {
      const box = document.createElement("div");
      box.className = `box ${colors[i % 2]}`;
      box.textContent = fib[i];
      outputContainer.appendChild(box);
    }