import ModelClient, { isUnexpected } from "@azure-rest/ai-inference";
import { AzureKeyCredential } from "@azure/core-auth";

const token = process.env["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"];
if (!token) {
  throw new Error("The GITHUB_TOKEN environment variable is not set.");
}
const endpoint = "https://models.inference.ai.azure.com";
const modelName = "DeepSeek-V3";

export async function main() {

  const client = ModelClient(
    endpoint,
    new AzureKeyCredential(token),
  );

  const response = await client.path("/chat/completions").post({
    body: {
      messages: [
        { role: "user", content: "What are the issues in my code?" },
        { role: "system", content: "Identify issues in the code and suggest fixes." },
      ],
      model: modelName,
    }
  });

  if (isUnexpected(response)) {
    throw response.body.error;
  }

  for (const choice of response.body.choices) {
    console.log(choice.message.content);
    // می‌توانید اینجا کدهای پیشنهادی را اعمال کنید
  }
}

main().catch((err) => {
  console.error("The sample encountered an error:", err);
});