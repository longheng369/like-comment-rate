import { useEffect, useState } from "react";
import { Card } from "../components/Card";
import axios from "axios";
import "react-loading-skeleton/dist/skeleton.css";
import CardSkeleton from "../Skeleton/CardSkeleton";

const Favorite = () => {
  const [newArrival, setNewArrival] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [refreshData, setRefreshData] = useState(false);

  const user_data = JSON.parse(localStorage.getItem('user_data'))
  const token = user_data?.token;

  const handleLikeClick = async (id, isLiked) => {
    // Optimistic update: Update UI immediately
    setNewArrival((prevArrival) => {
      return prevArrival.map((item) => {
        if (item.id === id) {
          const updatedLikesCount = isLiked
            ? item.upvotes_counts - 1
            : item.upvotes_counts + 1;
          return {
            ...item,
            isLiked: !isLiked,
            upvotes_counts: updatedLikesCount,
          };
        }
        return item;
      });
    });

    // Send request to upvote endpoint with the product ID
    try {
      await axios.post(
        `http://127.0.0.1:8000/api/products/${id}/upvote`,
        { is_upvote: !isLiked },
        {
          headers: {
            "Content-Type": "application/json",
            Authorization:
            `Bearer ${token}`,
          },
        }
      );
    } catch (error) {
      console.error("Error updating like state", error);
      // If request fails, revert UI to previous state
      setRefreshData((prev) => !prev);
    }
  };

  const handleFavoriteClick = async (id, isFavorited) => {
    setNewArrival((preview) => {
      return preview.map((item) => {
        if (item.id === id) {
          return { ...item, isFavorited: !isFavorited };
        }
        return item;
      });
    });

    if (isFavorited === false) {
      // Send request to upvote endpoint with the product ID
      try {
        await axios.post(
          `http://127.0.0.1:8000/api/products/${id}/favorite`,
          {},
          {
            headers: {
              "Content-Type": "application/json",
              Authorization:
              `Bearer ${token}`,
            },
          }
        );
      } catch (error) {
        console.error("Error updating favorite state", error);
        // If request fails, revert UI to previous state
        setRefreshData((prev) => !prev);
      }
    } else {
      // Send request to upvote endpoint with the product ID
      try {
        await axios.delete(
          `http://127.0.0.1:8000/api/products/${id}/favorite`,

          {
            headers: {
              "Content-Type": "application/json",
              Authorization:
              `Bearer ${token}`,
            },
          }
        );
      } catch (error) {
        console.error("Error updating favorite state", error);
        // If request fails, revert UI to previous state
        setRefreshData((prev) => !prev);
      }
    }
  };

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          "http://127.0.0.1:8000/api/items-with-likes-favorites",
          {
            headers: {
              "Content-Type": "application/json",
              Authorization:
              `Bearer ${token}`,
            },
          }
        );

        const { data, likedItems, favoriteItems } = response.data;

        const newArrivalData = data.map((card) => ({
          ...card,
          isLiked: likedItems.includes(card.id),
          isFavorited: favoriteItems.includes(card.id),
        }));

        setNewArrival(newArrivalData);
      } catch (error) {
        console.error("Error fetching data: ", error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, [refreshData]);

  return (
    <div className="w-full grid grid-cols-5 container mx-auto gap-6 py-4">
      {isLoading && (
        <div>
          <CardSkeleton />
        </div>
      )}

      {newArrival
          .filter((d) => d.isFavorited === true)
          .map((item) => (
            <Card
              {...item}
              key={item.id}
              comments={item.comments}
              onLikeClick={handleLikeClick}
              onFavoriteClick={handleFavoriteClick}
            />
          ))}
      
    </div>
  );
};

export default Favorite;
