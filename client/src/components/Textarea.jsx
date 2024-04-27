import axios from "axios";
import { useEffect, useRef, useState } from "react";
import { useParams } from "react-router-dom";

const Textarea = () => {
  const { id } = useParams();
  const [body, setBody] = useState("");
  const textareaRef = useRef(null);

  useEffect(() => {
    const textarea = textareaRef.current;
    if (!textarea) return;
    textarea.style.height = "50px"; // Reset height to ensure correct calculation
    textarea.style.height = textarea.scrollHeight + "px"; // Set to scroll height
  }, [body]);


  const handleChange = (event) => {
    setBody(event.target.value);
  };

  const handleComment = async () => {
    try {
      const response = await axios.post(
        `http://127.0.0.1:8000/api/products/${id}/comment`,
        { body: body },
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer 2|M4mPFWadjI0DffUemtXhDoKFgDcHFunVpiEmo3kRa78b76df",
          },
        }
      );
      console.log(response.data); // For debugging, see what the API responded with
    } catch (error) {
      console.error(error);
    }
  };
  return (
    <div className="flex items-start w-11/12">
      <textarea
        ref={textareaRef}
        className="w-[90%] rounded-lg outline-none border-2 shadow-sm resize-none overflow-hidden text-lg p-2 max-h-[200px]"
        placeholder="Type your message here..."
        value={body}
        onChange={handleChange}
      />
      <div className="ml-2 flex-shrink-0">
        <button
          onClick={handleComment}
          className="px-4 py-2 rounded-lg bg-blue-500 text-lg whitespace-nowrap text-white"
        >
          Comment
        </button>
      </div>
    </div>
  );
};

export default Textarea;
